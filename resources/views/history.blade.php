@extends('layouts.app')

@section('content')
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>History</title>

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
                    <th>Descripción</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Opciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ implode(", ", $order->description) }}</td>
                        <td>{{ "$" . $order->total }}</td>
                        <td>{{ $order->status }}</td>
                        <td>
                            <form action="{{ route('history.retryPayment', $order) }}" method="GET">
                                @method('GET')
                                @csrf
                                @if($order->status == 'REJECTED')
                                <a href="{{ route('history.retryPayment', $order->id) }}"
                                   type="submit"
                                   class="btn btn-sm btn-info">Reintentar pago</a>
                                @endif
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
