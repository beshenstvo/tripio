@extends('../../layout')
@section('title', 'Главная')

@section('content')
    <h1>Куда едем? Э?</h1>
    <routes-component :cities=" {{ App\Models\City::all() }}"></routes-component>
@endsection('content')