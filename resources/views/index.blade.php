@extends('layouts.default', ['name' => $name, 'description' => $description])
@section('content')
<header id="header">
    <section class="header-section">
        <div>
            <h1 class="title-name">{{ $name }}</h1>
            <br>
            <br>
            <div class="spacer"></div>
            <p>{{ $description }}</p>
            <div class="spacer"></div>
            <br>
            <br>
            <br>

            <form action="/" method="POST">
                @csrf
                <input type="date" name="selected_day" value="{{ old('selected_day') }}">
                <button class="button" type="submit"><i class="fas fa-search"></i></button>
            </form>
            @if ($errors->any())

            @foreach ($errors->all() as $error)
            <p class="error">
                {{ $error }}
            </p>
            @endforeach
            </ul>
            <br />


            @endif
            <br>
            <br>
            <i class="ouverture">Les réservation sont possible de <strong>{{ $hours[0] }}H</strong> à <strong>{{ $hours[1] }}H</strong> du
                @if ($days[0] == "Monday")
                <strong> Lundi </strong>
                @endif
                @if ($days[0] == "Tuesday")
                <strong> Mardi </strong>
                @endif
                @if ($days[0] == "Wednesday")
                <strong> Mercredi </strong>
                @endif
                @if ($days[0] == "Thursday")
                <strong> Jeudi </strong>
                @endif
                @if ($days[0] == "Friday")
                <strong> Vendredi </strong>
                @endif
                @if ($days[0] == "Saturday")
                <strong> Samedi </strong>
                @endif
                @if ($days[0] == "Sunday")
                <strong> Dimanche </strong>
                @endif

                au
                @if (end($days) == "Monday")
                <strong> Lundi </strong>
                @endif
                @if (end($days) == "Tuesday")
                <strong> Mardi </strong>
                @endif
                @if (end($days) == "Wednesday")
                <strong> Mercredi </strong>
                @endif
                @if (end($days) == "Thursday")
                <strong> Jeudi </strong>
                @endif
                @if (end($days) == "Friday")
                <strong> Vendredi </strong>
                @endif
                @if (end($days) == "Saturday")
                <strong> Samedi </strong>
                @endif
                @if (end($days) == "Sunday")
                <strong> Dimanche </strong>
                @endif
            </i>
        </div>
    </section>
</header>
<main id="main">
    @if (isset($_GET['success']) && $_GET['success'] === "1")
    <p class="success">Votre annulation a bien été prise en compte ! Nous espérons que vous viendrez nous visiter ultérieurement.</p>
    @endif


    @if (isset($_GET['success']) && $_GET['success'] === "2")
    <p class="success">Votre réservation a bien été prise en compte</p>
    @endif


    @if (isset($_GET['error']) && $_GET['error'] === "1")
    <p class="error-label">Réservation introuvable</p>
    @endif

    <section id="about">
        <h1>A PROPOS</h1>
        <p>{{ $long_description }} </p>
        <p>Adresse : {{ $address }} </p>
    </section>
    <section id="map">

        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d656.1823468282673!2d2.3478323292295036!3d48.86337048096053!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66e19042b1305%3A0xf2a23000a6c66d6d!2sReset!5e0!3m2!1sfr!2sfr!4v1614461600101!5m2!1sfr!2sfr" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </section>
</main>

@endsection