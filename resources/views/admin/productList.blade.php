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

    @if (session()->has('success_message'))
        <div class="alert alert-success">
            {{ session()->get('success_message') }}
        </div>
    @endif

    @if(count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-sm-12 mx-auto">
                <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-funnel-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2z"/>
                    </svg>
                </a>
{{--            <div class="container text-right">--}}
                <a href="{{ route('products.export', request()->all()) }}" class="btn btn-success">Exportar</a>
                <a href="#" class="btn btn-success" data-toggle="modal" data-target="#import">Importar</a>
{{--            </div>--}}
            @include('admin.import')
            <div class="collapse" id="collapseExample">
                <form action="#">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="name">name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="category">Categoria</label>
                            <select id="category" name="category" class="form-control">
                                <option value data-isdefault="true">Todas</option>
                                <option value="1">shooters</option>
                                <option value="2">horror</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="price">Precio</label>
                            <input type="number" class="form-control" id="price" name="price" placeholder="$">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="visible">Disponibilidad</label>
                            <select id="visible" name="visible" class="form-control">
                                <option value data-isdefault="null">Todos</option>
                                <option value="1">En stock</option>
                                <option value=false>Fuera de stock</option>
                            </select>
                        </div>
                    </div>
{{--                    <div class="form-row">--}}
{{--                        <div class="form-group col-md-4">--}}
{{--                            <label for="date-from">Fecha desde</label>--}}
{{--                            <input type="date" class="form-control" id="date-from" name="date-from" placeholder="">--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-md-4">--}}
{{--                            <label for="date-to">Fecha hasta</label>--}}
{{--                            <input type="date" class="form-control" id="date-to" name="date-to" placeholder="">--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <button type="submit" class="btn btn-primary">Filtrar ✓</button>
                </form>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Detalles</th>
                    <th>Descripcion</th>
                    <th>Opciones</th>
                    <th><a href="{{ route('products.create') }}" class="btn btn-sm btn-dark">Agregar Producto</a></th>
                </tr>
                </thead>
                @include('admin.import')
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->short_description }}</td>
                        <td>{{ $product->description }}</td>
                        @if ($product->visible == 1)
                            <td>{{ 'Activo' }}</td>
                        @else
                            <td>{{ 'Inactivo' }}</td>
                        @endif
                        <td>
                            <form action="{{ route('products.visible', $product) }}" method="POST">
                                @method('PATCH')
                                @csrf
                                @if ($product->visible == 1)
                                    <input type="submit"
                                           value="Desactivar"
                                           class="btn btn-sm btn-secondary">
                                @else
                                    <input type="submit"
                                           value="Activar"
                                           class="btn btn-sm btn-secondary">
                                @endif
                            </form>
                            <form action="{{ route('products.destroy', $product) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <a href="{{ route('products.edit', $product->id) }}"
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

<div class="pagination"></div>
{{ $products->links() }}
</div>

@endsection

{{--      @if ($user->active==1)
 value="Desactivar"
 @else
 value="Activar      "
 @endif  --}}
