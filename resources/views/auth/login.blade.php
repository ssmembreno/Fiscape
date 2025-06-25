@extends('_layouts.Auth_layout')

@section('login')

    <form action="{{url('/login')}}" method="POST">
    @csrf
    <input type="text" id="email" name="email">Email
    <input type="password" id="password" name="password">Password

    <button type="submit">Iniciar sesion</button>
    </form>
@endsection