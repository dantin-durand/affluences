<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle réservation</title>
</head>

<body style="background-color: #060040;color: #fff;margin: 0;padding: 50px;">
    <h1 style="color: #fffa0a; font-family: monospace;">Nouvelle réservation</h1>

    <br />
    <p style="color: #fff; font-family: monospace;">Vous avez selectionné la plage horaire suivante pour votre visite à notre musée: </p>
    <br />
    <ul style="color: #fff; font-family: monospace;">
        <li>Jour réservé: {{ $selected_day }}</li>
        <li>Heure réservé: {{ $selected_hour }}</li>
    </ul>
    <br><br>

    <a href="http://localhost:8000/reservation/annulation/{{ $token }}" style="color: #cecece;border: 0px;font-family: monospace;">Annuler la réservation</a>

</body>


</html>