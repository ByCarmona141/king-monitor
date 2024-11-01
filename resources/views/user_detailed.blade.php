@extends('king-monitor::layouts.app')

@section('title')
    {{ config('app.name', 'Monitor') }} - User - Detailed
@endsection

@section('header')
    <header class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            {{ __('Monitor') }} - User
        </div>
    </header>
@endsection

@section('content')
    <h1>Detailed</h1>
@endsection