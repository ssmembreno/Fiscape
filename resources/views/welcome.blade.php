<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Document</title>
</head>
<body>
    <h1 class="text-3xl">FISCAPE</h1>

    <button class="bg-orange-100">
        <h2><a href="{{route('login')}}">Login</a></h2>
    </button>

    <button class="bg-orange-300">
        <h2 ><a href="{{ route('register') }}">Registrarse</a></h2>
    </button>
</body>
</html>


