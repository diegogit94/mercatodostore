@extends('layouts.app')

@section('content')
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MercaTodo</title>

    <!-- Fonts -->
{{-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet"> --}}

<!-- Styles -->

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
                    <th>Detalles</th>
                    <th>Descripcion</th>
                    <th>Opciones</th>
                    <th><a href="{{ route('products.create') }}" class="btn btn-sm btn-dark">Agregar Producto</a></th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->short_description }}</td>
                        <td>{{ $product->description }}</td>
{{--                        @if ($product->active == 1)--}}
{{--                            <td>{{ 'Activo' }}</td>--}}
{{--                        @else--}}
{{--                            <td>{{ 'Inactivo' }}</td>--}}
{{--                        @endif--}}
                        <td>
{{--                            <form action="{{ route('users.activate', $user) }}" method="POST">--}}
{{--                                @method('PATCH')--}}
{{--                                @csrf--}}
{{--                                @if ($user->active == 1)--}}
{{--                                    <input type="submit"--}}
{{--                                           value="Desactivar"--}}
{{--                                           class="btn btn-sm btn-secondary">--}}
{{--                                @else--}}
{{--                                    <input type="submit"--}}
{{--                                           value="Activar"--}}
{{--                                           class="btn btn-sm btn-secondary">--}}
{{--                                @endif--}}
{{--                            </form>--}}
{{--                            <form action="{{ route('users.destroy', $user) }}" method="POST">--}}
{{--                                @method('DELETE')--}}
{{--                                @csrf--}}
{{--                                <a href="{{ route('users.edit', $user->id) }}"--}}
{{--                                   type="submit"--}}
{{--                                   class="btn btn-sm btn-info">Editar</a>--}}
{{--                                <input type="submit"--}}
{{--                                       value="Eliminar"--}}
{{--                                       class="btn btn-sm btn-danger"--}}
{{--                                       onclick="return confirm('¿Desea elminar?')">--}}
{{--                            </form>--}}
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

<div class="pagination"></div>
{{ $products->links() }}
</div>

@endsection

{{--      @if ($user->active==1)
 value="Desactivar"
 @else
 value="Activar      "
 @endif  --}}
