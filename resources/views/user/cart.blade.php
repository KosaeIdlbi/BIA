<link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@extends('user.layouts.master')
@section('title')
    السلة
@endsection

@section('content')
    @livewire('view-cart', ['user' => $user])
@endsection
