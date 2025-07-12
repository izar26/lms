@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <h1 class="mb-4">Admin Dashboard</h1>

    <div class="card">
        <div class="card-body">
            Halo, **{{ Auth::user()->name }}**. Selamat datang di panel admin manual!
        </div>
    </div>
@endsection