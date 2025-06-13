@extends('adminlte::page')

@section('title', 'Nueva membresía')

@section('content_header')
    <div class="col-lg-12 text-right">
        <div class="btn-group" role="group" aria-label="Acciones de Membresía">
            <button class="btn btn-success mr-2" data-toggle='modal' data-target="#createMembresia">
                <i class="fa fa-plus"></i> Registrar Membresía
            </button>
        </div>
    </div>
@endsection

@section('content')
    <p>Welcome to this beautiful admin panel.</p>

    {{-- Aquí incluimos el modal para registrar membresías --}}
    @include('membresias.create')
@endsection

@section('css')
    {{-- Estilos personalizados opcionales --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endsection

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@endsection