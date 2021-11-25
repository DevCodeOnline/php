@extends('layouts.layout')
@section('title', 'Контакты интернет магазина')
@section('best')
    @include('layouts.best')
@endsection
@section('content')
    <div class="main-content">
        <div class="contact">
            <div class="contact-text">
                {!! $contact->content !!}
            </div>
        </div>
    </div>
@endsection
@push('scripts')

@endpush
