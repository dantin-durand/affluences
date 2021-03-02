<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class ReservationAmoutLimit implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($selected_day, $selected_hour)
    {
        $this->selected_day = $selected_day;
        $this->selected_hour = $selected_hour;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $reservation_limit = Config::get('information.reservation_timetable');
        if (intval($value) < $reservation_limit[0] || intval($value) > end($reservation_limit)) {
            return false;
        }

        $reservationArrayQuerry = DB::table('affluences')
            ->select('*')
            ->where(
                'selected_day',
                $this->selected_day
            )
            ->where(
                'selected_hour',
                $this->selected_hour
            );

        $reservationArray = $reservationArrayQuerry->get();

        $hasReservationLimitNotBeenReached = count($reservationArray) < Config::get('information.reservation_limit');

        if ($hasReservationLimitNotBeenReached) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "L'horaire selectionné n'est pas disponible.";
    }
}
