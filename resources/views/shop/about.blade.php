@extends('layouts.layout')
@section('title', 'Информация об интернет магазине')
@section('best')
    @include('layouts.best')
@endsection
@section('content')
    <div class="main-content">
        <div class="about">
            <div class="about-img">
                <img src="{{ $info->getImage() }}" alt="About">
            </div>
            <div class="about-text">
                {!! $info->content !!}
            </div>
        </div>
    </div>
@endsection
@push('scripts')

@endpush
