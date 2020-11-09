@extends('layout')

@section('title', 'Thank You')

@section('extra-css')

@endsection

@section('body-class', 'sticky-footer')

@section('content')

   <div class="thank-you-section">
       @if ($status == 'PENDING')
           <h1>Your order was <br> {{ $status }}</h1>
           <p>We will notify to your email when the order status has change,
           also you can check the history.</p>
       @else
           <h1>Your order was <br> {{ $status }}</h1>
       @endif
       <div class="spacer"></div>
       <div>
           <a href="{{ url('/') }}" class="button">Home Page</a>
       </div>
   </div>

@endsection
