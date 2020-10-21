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
@if(!empty($orders))
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
                        <td>{{ formatPrice($order->total) }}</td>
                        <td>{{ $order->status }}</td>
                        <td>
                            <form action="{{ route('history.retryPayment', $order) }}" method="GET">
                                @method('GET')
                                @csrf
                                @if($order->status == 'REJECTED' || $order->status =='FAILED')
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
@else
    <div class="thank-you-section">
        <h1>There's no purchases :c</h1>
        <div class="spacer"></div>
        <div>
            <a href="{{ route('store.index') }}" class="button">Buy something</a>
        </div>
    </div>
@endif
</body>
</html>
<div class="pagination"></div>
{{ $orders->links() }}
@endsection
