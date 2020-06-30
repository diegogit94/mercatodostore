@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>MercaTodo</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 mx-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Estado</th>
                                <th>Opciones</th>
                                <th><a href="{{ route('create.user') }}" class="btn btn-sm btn-dark">Agregar Usuario</a></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                @if ($user->active==1)
                                <td>{{ 'Activo' }}</td>
                                @else
                                <td>{{ 'Inactivo' }}</td>
                                @endif
                                <td>
                                    <form action="{{ route('users.activate', $user) }}" method="POST">
                                        @method('PATCH')
                                        @csrf
                                        @if ($user->active == 1)
                                        <input type="submit" 
                                        value="Desactivar" 
                                        class="btn btn-sm btn-secondary">
                                        @else
                                        <input type="submit" 
                                        value="Activar" 
                                        class="btn btn-sm btn-secondary">
                                        @endif
                                    </form>
                                    <form action="{{ route('users.destroy', $user) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <a href="{{ route('users.edit', $user->id) }}" 
                                        type="submit"
                                        class="btn btn-sm btn-info">Editar</a>
                                        <input type="submit" 
                                        value="Eliminar" 
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('¿Desea elminar?')">
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
@endsection

                                       {{--      @if ($user->active==1)
                                        value="Desactivar"
                                        @else
                                        value="Activar      "
                                        @endif  --}}