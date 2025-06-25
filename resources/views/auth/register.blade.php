@extends('_layouts.Auth_layout')

@section('register')

    @include('_layouts.Errors_layout')
    
    <form action="{{url('/register')}}" method="POST">
    @csrf
    Email<input type="text" id="email" name="email">
    Nombre<input type="text" id="name" name="name">
    Password<input type="password" id="password" name="password">
    Confirmar Password<input type="password" id="password_confirmation" name="password_confirmation">

    <button type="submit">Registrarse</button>
    </form>
@endsection
