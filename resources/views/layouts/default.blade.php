<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/ee9709fe10.js" crossorigin="anonymous"></script>
    <link href="../../css/app.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../img/favicon.png" type="image/png">
    <title>{{ucfirst($name)}}</title>
</head>

<body>


    @yield('content')

    @include('partials.footer')

</body>

</html>