@extends('layouts.default', ['name' => $name, 'description' => $description])
@section('content')
@include('partials.navbar', ['name' => $name,'page' => "Annulation"])
<main id="main">

    <section id="reservation">
        @if ($errors->any())
        @foreach ($errors->all() as $error)
        <p class="error">{{ $error }}</p>
        @endforeach
        <br><br>
        @endif

        <h4>Annulation de reservation</h4>
        <br>
        <form method="POST">
            <div class="reservation-container">

                @csrf
                <p>Le {{ $selected_day }} à {{ $selected_hour}}H</p>
                <br>

                <p><strong>Durée de la visite: </strong>{{ $reservation_duration }} heure
                </p>


            </div>
            <div class="validation-remove-reservation">
                <input name="confirm_annulation" type="checkbox" id="confirm">

                <label for="confirm">Je souhaite annuler ma réservation</label>
                <br>
                <br>
                <button type="submit" class="button">Annuler ma réservation</button>
            </div>
        </form>

    </section>
</main>
@endsection