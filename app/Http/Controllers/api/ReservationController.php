<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
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
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'selected_day' => ['required', 'date', 'after_or_equal:now'],
            'selected_hour' => ['required', 'numeric'],
            'cgu' => 'required',
        ]);
        $verifEmail = DB::table('affluences')
            ->select('email')
            ->where(
                'email',
                $request->get('email')
            )
            ->where(
                'selected_day',
                $request->get('selected_day')
            )
            ->where(
                'selected_hour',
                $request->get('selected_hour')
            );

        // Verif Email
        if (count($verifEmail->get()) >= 1) {
            $request = [
                'message' => "Vous avez déjà réservé cette horaire."
            ];
            return response($request, 400);
        }
        // Verif Hours
        $reservation_limit = Config::get('information.reservation_timetable');
        if (intval($request->get('selected_hour')) < $reservation_limit[0] || intval($request->get('selected_hour')) > end($reservation_limit)) {
            $request = [
                'message' => "Heure de réservation non valide."
            ];
            return response($request, 400);
        }
        // Verif number reservation
        $reservationArrayQuerry = DB::table('affluences')
            ->select('*')
            ->where(
                'selected_day',
                $request->get('selected_day')
            )
            ->where(
                'selected_hour',
                $request->get('selected_hour')
            );

        $reservationArray = $reservationArrayQuerry->get();


        if (count($reservationArray) > Config::get('information.reservation_limit')) {
            $request = [
                'message' => "Heure de réservation Indisponible"
            ];
            return response($request, 400);
        }



        // Verif Date
        $timestamp = strtotime($request->get('selected_day'));
        $day = date('l', $timestamp);

        if (!in_array($day, Config::get('information.reservation_days'))) {
            $request = [
                'message' => "Le jour selectionné n'est pas disponible."
            ];
            return response($request, 400);
        }

        $formatedDate =  date("d/m/Y", strtotime($request->get('selected_day')));

        $params = [
            'subject' => "Nouvelle réservation",
            'email' => $request->get('email'),
            'selected_hour' => $request->get('selected_hour'),
            'selected_day' => $formatedDate,
            'token' => sha1(mt_rand(1, 90000) . 'SALT'),
            'url' => env('APP_URL', null),
        ];


        DB::table('affluences')->insert([
            'email' => $params['email'],
            'selected_day' => $request->get('selected_day'),
            'selected_hour' => $params['selected_hour'],
            'token' => $params['token'],
        ]);

        Mail::to($params['email'])->send(new Notification($params));

        return response($params, 200);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

        return response(Config::get('information'), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showReservations(Request $request)
    {
        $reservationsQuerry = DB::table('affluences')->select('*')->where('selected_day', $request->date);
        $reservationsArray = $reservationsQuerry->get();
        $list = [];

        foreach ($reservationsArray as $reservation) {
            array_push($list, $reservation->selected_hour);
        };

        $sortedList = array_count_values($list);
        return response($sortedList, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
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

        if (count($reservationArray) >= 1) {
            $deleted = DB::delete('delete from affluences where token = ?', [$request->token]);

            $formatedDate =  date("d/m/Y", strtotime($reservationArray[0]->selected_day));
            $params = [
                'email' => $reservationArray[0]->email,
                'selected_hour' => $reservationArray[0]->selected_hour,
                'selected_day' => $formatedDate,
                'subject' => "Confimation d'annulation",
            ];

            Mail::to($reservationArray[0]->email)->send(new NotificationAnnulation($params));

            $response = [
                'message' => 'Réservation annulée avec succès.'
            ];

            return response($response, 200);
        } else {

            $response = [
                'message' => 'Réservation introuvable.'
            ];
            return response($response, 404);
        }
    }
}
