@extends('layouts.app')

@section('content')
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>MercaTodo</title>

    </head>
    <body>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        <div class="container">
            <h2>Usuarios</h2>
            <p class="lead">This example is a quick exercise to illustrate how the bottom navbar works.</p>
            <a class="btn btn-mid btn-success" href="{{ route('users.export') }}" role="button">Exportar ⇩</a>
            <a class="btn btn-mid btn-success" href="#" role="button">Importar ⇧</a>
        </div>
        <div class="container">
            <br><h2>Productos</h2>
            <p class="lead">This example is a quick exercise to illustrate how the bottom navbar works.</p>
            <a class="btn btn-mid btn-success" href="{{ route('products.export') }}" role="button">Exportar ⇩</a>
            <a class="btn btn-mid btn-success" href="#" role="button">Importar ⇧</a>
        </div>
        <div class="container">
            <br><h2>Ordenes</h2>
            <p class="lead">This example is a quick exercise to illustrate how the bottom navbar works.</p>
            <a class="btn btn-mid btn-success" href="#" role="button">Exportar ⇩</a>
            <a class="btn btn-mid btn-success" href="#" role="button">Importar ⇧</a>
        </div>
    </body>
</html>
@endsection
