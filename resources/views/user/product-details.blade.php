<link rel="stylesheet" href="{{ url('css/product-details.css') }}">
@extends('user.layouts.master')
@section('title')
    المنتج
@endsection

@section('content')
    @livewire('product-details', ['user_id' => $user ? $user->id : null, 'product' => $product])
@endsection
