<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Généalogie</title>
</head>
<body>
    @auth
        <p>Connecté en tant que {{ Auth::user()->name }}</p>
    @endauth

    @yield('content')
</body>
</html>
