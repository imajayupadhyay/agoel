@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <section class="dashboard-welcome">
        <div>
            <p class="dashboard-eyebrow">Admin dashboard</p>
            <h2>Hello, Admin.</h2>
            <p class="dashboard-copy">
                You are securely signed in as {{ auth()->user()->email }}.
                Dashboard modules can be added here in the next phase.
            </p>
        </div>
    </section>
@endsection
