@extends('layouts.default' , ['name' => $name, 'description' => $description])
@section('content')

@include('partials.navbar', ['name' => $name,'page' => "Réservation"])

<main id="main">
    <section id="reservation">
        <form method="POST">
            @if ($errors->any())
            @foreach ($errors->all() as $error)
            <p class="error">{{ $error }}</p>
            @endforeach
            <br><br>
            @endif

            @csrf
            <h4>
                Choisissez un craineaux de visite
            </h4>

            @if (!isset($_GET['selected_day']))
            <div class="date-input">

                <label for="selected_day">Date de la réservation</label>
                <input type="date" name="selected_day" id="selected_day" value="{{ old('selected_day') }}">

            </div>
            @endif

            <h5>Craineaux horaires: </h5>
            <div class="horaires">

                <?php
                for ($i = $reservation_timetable[0]; $i <= $reservation_timetable[1]; $i += $reservation_duration) {
                    ddd($existing_reservations);
                    if (isset($existing_reservations[$i])) {
                        if ($existing_reservations[$i] >= $reservation_limit) {

                            echo
                            "<p><input name='selected_hour' type='radio' id=" . $i . "h value='$i' disabled/>
                        <label for=" . $i . "h> " . $i . "h  <br><br> <i class='fas fa-user-tag'></i>  $existing_reservations[$i]/$reservation_limit </label></p>";
                        } else {

                            echo
                            "<p><input name='selected_hour' type='radio' id=" . $i . "h value='$i' />
                        <label for=" . $i . "h> " . $i . "h  <br><br> <i class='fas fa-user-tag'></i> $existing_reservations[$i]/$reservation_limit </label></p>";
                        }
                    } else {
                        echo
                        "<p><input name='selected_hour' type='radio' id=" . $i . "h value='$i' />
                        <label for=" . $i . "h> " . $i . "h  <br><br> <i class='fas fa-user-tag'></i> 0/$reservation_limit </label></p>";
                    }
                }
                ?>
            </div>

            </div>
            <div class="email-input">

                <label for="email">Adresse mail</label>
                <input type="email" name="email" id="email" placeholder="game@reset.com" value="{{ old('email') }}" />
            </div>
            <button type="submit" class="button">Réserver</button>

        </form>
    </section>
</main>


@endsection