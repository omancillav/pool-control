@extends('adminlte::page')

@section('title', 'Nueva Clase')

@section('content_header')
    <h1>Registrar Nueva Clase</h1>
@endsection

@section('content')
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Registrar Nueva Clase</h3>
        </div>
        <form action="{{ route('clases.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <!-- Fecha -->
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="fecha">Fecha (*)</label>
                            <input type="date" class="form-control" id="fecha" name="fecha" required>
                        </div>
                    </div>

                    <!-- Profesor -->
                    <div class="col-lg-8">
                        <div class="form-group">
                            <label for="id_profesor">Profesor (*)</label>
                            <select class="form-control" id="id_profesor" name="id_profesor" required>
                                <option value="" disabled selected>Seleccione un profesor</option>
                                @foreach ($profesores as $profesor)
                                    <option value="{{ $profesor->id }}">{{ $profesor->name }} {{ $profesor->last_name ?? '' }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Tipo -->
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="tipo">Tipo (*)</label>
                            <input type="text" class="form-control" id="tipo" name="tipo" placeholder="Ej: Presencial, Virtual" required>
                        </div>
                    </div>

                    <!-- Lugares -->
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="lugares">Lugares Totales (*)</label>
                            <input type="number" class="form-control" id="lugares" name="lugares" min="0" required>
                        </div>
                    </div>

                    <!-- Lugares Ocupados -->
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="lugares_ocupados">Lugares Ocupados (*)</label>
                            <input type="number" class="form-control" id="lugares_ocupados" name="lugares_ocupados" min="0" required>
                        </div>
                    </div>

                    <!-- Lugares Disponibles -->
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="lugares_disponibles">Lugares Disponibles (*)</label>
                            <input type="number" class="form-control" id="lugares_disponibles" name="lugares_disponibles" min="0" required>
                        </div>
                    </div>

                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success float-right">Registrar Clase</button>
            </div>
        </form>
    </div>
@endsection

@section('css')
    {{-- Estilos personalizados opcionales --}}
@endsection

@section('js')
    {{-- Scripts personalizados opcionales --}}
@endsection