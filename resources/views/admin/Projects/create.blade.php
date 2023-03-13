@extends('layouts.app')

@section('title', 'Crea un nuovo progetto')


@section('content')

    <header>
        {{-- <h1 class="my-5">{{ $project->title }}</h1> --}}
        <h1 class="my-5">Crea</h1>
    </header>

    <hr>

    @include('includes.projects.form')


@endsection
