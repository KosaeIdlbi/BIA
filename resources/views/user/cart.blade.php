<link rel="stylesheet" href="{{ url('css/cart.css') }}">
@extends('user.layouts.master')
@section('title')
    السلة
@endsection

@section('content')
    @livewire('view-cart', ['user' => $user])
@endsection
