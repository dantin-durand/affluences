<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation Annuler</title>
</head>

<body style="background-color: #060040;color: #fff;margin: 0;padding: 50px;">
    <h1 style="color: #fffa0a; font-family: monospace;">Réservation annulée</h1>
    <br />
    <p style="color: #fff; font-family: monospace;">Votre réservation a bien été annulée.</p>
    <br />
    <ul style="color: #fff; font-family: monospace;">
        <li>Jour réservé: {{ $selected_day }}</li>
        <li>Heure réservé: {{ $selected_hour }}</li>
    </ul>


</body>

</html>