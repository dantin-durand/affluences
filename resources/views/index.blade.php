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
        <p>{{ $lng }}</p>
    </section>
    <section id="map">
        <div id="mapgoogle"></div>
    </section>
</main>
<script async src="https://maps.googleapis.com/maps/api/js?key={{ $api_key }}&callback=initMap">
</script>
<script>
    let map;
    let marker;
    const lat = '{{ $lat }}';
    const lng = '{{ $lng }}';

    function initMap() {
        const position = {
            lat: Number(lat),
            lng: Number(lng)
        };

        map = new google.maps.Map(document.getElementById("mapgoogle"), {
            center: position,
            zoom: 8,
        });
        marker = new google.maps.Marker({
            position: position,
            map: map,
        });
    }
</script>
@endsection