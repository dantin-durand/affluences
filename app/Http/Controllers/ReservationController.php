<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\Notification;
use App\Mail\NotificationAnnulation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use DateTime;
use App\Rules\ReservationDayLimits;
use App\Rules\ReservationAmoutLimit;

class ReservationController extends Controller
{
    public function reservation(Request $request)
    {
        return view(
            'reservation.reservation',
            Config::get('information'),
            [
                'existing_reservations' => $this->getReservations($request->selected_day),
                'selected_day' => $request->selected_day
            ]
        );
    }

    public function getReservations($selectedDay)
    {
        $reservationsQuerry = DB::table('affluences')->select('*')->where('selected_day', $selectedDay);
        $reservationsArray = $reservationsQuerry->get();
        $list = [];

        foreach ($reservationsArray as $reservation) {
            array_push($list, $reservation->selected_hour);
        };

        $sortedList = array_count_values($list);
        return $sortedList;
    }

    public function sendReservation(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'selected_day' => ['required', 'date', new ReservationDayLimits, 'after_or_equal:now'],
            'selected_hour' => ['required', 'numeric', new ReservationAmoutLimit($request->get('selected_day'), $request->get('selected_hour'))],
        ]);

        $formatedDate =  date("d/m/Y", strtotime($request->get('selected_day')));

        $params = [
            'email' => $request->get('email'),
            'selected_hour' => $request->get('selected_hour'),
            'selected_day' => $formatedDate,
            'token' => sha1(mt_rand(1, 90000) . 'SALT'),
            'subject' => "Nouvelle réservation",
            'url' => env('APP_URL', null),
        ];


        DB::table('affluences')->insert([
            'email' => $params['email'],
            'selected_day' => $request->get('selected_day'),
            'selected_hour' => $params['selected_hour'],
            'token' => $params['token'],
        ]);

        Mail::to($params['email'])->send(new Notification($params));


        $routeParams = [
            'success' => "2"
        ];

        return redirect()->route('index', $routeParams);
    }

    public function removeReservation(Request $request)
    {
        $configs = Config::get('information');
        $reservationArray = DB::select('select * from affluences where token = ?', [$request->token]);
        if (!$reservationArray) {

            $routeParams = [
                'error' => "1"
            ];

            return redirect()->route('index', $routeParams);
        }
        $formatedDate =  date("d/m/Y", strtotime($reservationArray[0]->selected_day));

        $reservation = [
            'name' => $configs['name'],
            'description' => $configs['description'],
            'selected_hour' => $reservationArray[0]->selected_hour,
            'selected_day' => $formatedDate,
            'token' => $reservationArray[0]->token,
            'reservation_duration' => Config::get('information.reservation_duration'),
        ];

        return view('reservation.annulation', $reservation);
    }

    public function sendRemoveReservation(Request $request)
    {
        $validated = $request->validate([
            'confirm_annulation' => 'required',
        ]);


        $reservationArrayQuerry = DB::table('affluences')
            ->select('*')
            ->where(
                'token',
                $request->token
            );
        $reservationArray = $reservationArrayQuerry->get();
        if ($reservationArray) {
            $deleted = DB::delete('delete from affluences where token = ?', [$request->token]);

            $formatedDate =  date("d/m/Y", strtotime($reservationArray[0]->selected_day));
            $params = [
                'email' => $reservationArray[0]->email,
                'selected_hour' => $reservationArray[0]->selected_hour,
                'selected_day' => $formatedDate,
                'subject' => "Confimation d'annulation",
            ];

            Mail::to($reservationArray[0]->email)->send(new NotificationAnnulation($params));

            $routeParams = [
                'success' => "1"
            ];

            return redirect()->route('index', $routeParams);
        }
    }
}
