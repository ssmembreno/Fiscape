@extends('_layouts.layout')

@section('content')

<h1>DashBoard FISCAPE</h3>

<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Cerrar sesión</button>
</form>

<h1>Bienvenido, {{ auth()->user()->name }}</h1>


@endsection