@extends('layouts.app')

@section('title', 'WeAreSchool - Bem-vindo')

@section('content')
    <!-- Se quiseres uma landing page específica, edita aqui -->
    <!-- Por enquanto, redireciona para a Home do Livewire -->
    @livewire('home.index')
@endsection