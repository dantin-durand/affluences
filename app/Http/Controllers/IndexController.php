<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Rules\ReservationDayLimits;

class IndexController extends Controller
{
    public function index()
    {
        $configs = Config::get('information');
        $params = [
            'name' => $configs['name'],
            'address' => $configs['address'],
            'description' => $configs['description'],
            'long_description' => $configs['long_description'],
            'days' => $configs['reservation_days'],
            'hours' => $configs['reservation_timetable'],
        ];
        return view('index', $params);
    }
    public function postIndex(Request $request)
    {
        $validated = $request->validate([
            'selected_day' => ['required', 'date', new ReservationDayLimits, 'after_or_equal:now'],
        ]);



        $routeParams = [
            'selected_day' => $request->get('selected_day')
        ];

        return redirect()->route('reservation', $routeParams);
    }
}
