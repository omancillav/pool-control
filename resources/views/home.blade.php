@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')
    <div class="container-fluid">

                @if(Auth::user()->rol == 'Administrador')
            {{-- Admin Dashboard --}}
            @include('dashboards.admin', compact('totalUsuarios', 'totalMembresias', 'totalClases'))
        @elseif(Auth::user()->rol == 'Cliente')
            {{-- Client Dashboard --}}
            @include('dashboards.cliente', compact('membresia', 'clases', 'reservaciones'))
        @elseif(Auth::user()->rol == 'Profesor')
            {{-- Professor Dashboard --}}
            @include('dashboards.profesor', compact('clasesImpartidas'))
        @endif
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
@stop

@section('js')
@stop
