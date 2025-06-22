@extends('_layouts.layout')

@section('content')
    <h1>FISCAPE</h1>

    <button>
        <h2><a href="{{route('login')}}">Login</a></h2>
        
    </button>

    <button>
        <h2><a href="{{ route('register') }}">Registrarse</a></h2>
    </button>
@endsection


@vite('resources/js/app.js')
