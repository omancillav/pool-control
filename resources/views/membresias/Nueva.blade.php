@extends('adminlte::page')

@section('title', 'Nueva membresía')

@section('content_header')
    <h1>Nueva Membresía</h1>
@endsection

@section('content')
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Registrar Nueva Membresía</h3>
        </div>
        <form action="{{ route('membresias.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="id_usuario">Usuario(*)</label>
                            <select class="form-control" id="id_usuario" name="id_usuario" required>
                                <option value="" disabled selected>Seleccione un usuario</option>
                                @foreach ($usuarios as $usuario)
                                    <option value="{{ $usuario->id }}">{{ $usuario->name }} {{ $usuario->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="clases_adquiridas">Clases Adquiridas(*)</label>
                            <input type="number" class="form-control" id="clases_adquiridas" name="clases_adquiridas" min="0" required>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="clases_disponibles">Clases Disponibles(*)</label>
                            <input type="number" class="form-control" id="clases_disponibles" name="clases_disponibles" min="0" required>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="clases_ocupadas">Clases Ocupadas(*)</label>
                            <input type="number" class="form-control" id="clases_ocupadas" name="clases_ocupadas" min="0" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success float-right">Registrar Membresía</button>
            </div>
        </form>
    </div>
@endsection

@section('css')
    {{-- Estilos personalizados opcionales --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endsection

@section('js')
    {{-- Scripts personalizados opcionales --}}
@endsection