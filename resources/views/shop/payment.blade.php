@extends('layouts.layout')
@section('title', 'Оплата и доставка в интернет магазине')
@section('best')
    @include('layouts.best')
@endsection
@section('content')
    <div class="main-content">
        <div class="payment">
            <div class="payment-text">
                {!! $payment->content !!}
            </div>
        </div>
    </div>
@endsection
@push('scripts')

@endpush
