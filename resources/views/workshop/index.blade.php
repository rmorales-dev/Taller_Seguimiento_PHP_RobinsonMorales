@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Taller Seguimiento - Robinson Morales</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('workshop.index') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Panel Principal</li>
        </ol>
    </nav>
</div>

<section class="section dashboard">
    <div class="row">
        <div class="col-12">
            <div class="card info-card">
                <div class="card-body">
                    <h5 class="card-title">Bienvenido <span>| Programación Web PHP (MVC)</span></h5>
                    <p class="text-muted">
                        Solución a los 11 ejercicios prácticos orientados a la web utilizando un único controlador con funciones individuales y vistas independientes.
                    </p>
                </div>
            </div>
        </div>

        @php
            $exercises = [
                ['id' => 1, 'title' => 'Lista de Tareas', 'desc' => 'Agregar, marcar completadas y eliminar tareas.', 'icon' => 'bi-check2-square', 'color' => 'primary'],
                ['id' => 2, 'title' => 'Calculadora de Propinas', 'desc' => 'Cálculo de propina y total según porcentaje.', 'icon' => 'bi-calculator', 'color' => 'success'],
                ['id' => 3, 'title' => 'Generador de Contraseñas', 'desc' => 'Generador con longitud y tipos de caracteres.', 'icon' => 'bi-key', 'color' => 'warning'],
                ['id' => 4, 'title' => 'Gestor de Gastos', 'desc' => 'Registro de gastos, categorías y resumen mensual.', 'icon' => 'bi-cash-stack', 'color' => 'danger'],
                ['id' => 5, 'title' => 'Sistema de Reservas', 'desc' => 'Reserva de citas/servicios con disponibilidad.', 'icon' => 'bi-calendar-check', 'color' => 'info'],
                ['id' => 6, 'title' => 'Gestor de Notas', 'desc' => 'Crear notas categorizadas con buscador.', 'icon' => 'bi-journal-text', 'color' => 'secondary'],
                ['id' => 7, 'title' => 'Calendario de Eventos', 'desc' => 'Gestión de eventos con recordatorios.', 'icon' => 'bi-calendar-event', 'color' => 'primary'],
                ['id' => 8, 'title' => 'Plataforma de Recetas', 'desc' => 'Recetas con filtros por comida o ingredientes.', 'icon' => 'bi-egg-fried', 'color' => 'success'],
                ['id' => 9, 'title' => 'Juego de Memoria', 'desc' => 'Emparejar cartas con diferentes niveles.', 'icon' => 'bi-controller', 'color' => 'warning'],
                ['id' => 10, 'title' => 'Plataforma de Encuestas', 'desc' => 'Crear, responder encuestas e informe de resultados.', 'icon' => 'bi-card-checklist', 'color' => 'danger'],
                ['id' => 11, 'title' => 'Cronómetro Online', 'desc' => 'Inicio, pausa, reinicio y registro de vueltas.', 'icon' => 'bi-stopwatch', 'color' => 'info'],
            ];
        @endphp

        @foreach ($exercises as $item)
            <div class="col-xxl-4 col-md-6">
                <div class="card info-card">
                    <div class="card-body">
                        <h5 class="card-title">
                            @if ($item['id'] === 1)
                                <a href="{{ route('workshop.exercise1') }}" class="text-primary">Ejercicio {{ $item['id'] }} &raquo;</a>
                            @elseif ($item['id'] === 2)
                                <a href="{{ route('workshop.exercise2') }}" class="text-primary">Ejercicio {{ $item['id'] }} &raquo;</a>
                            @elseif ($item['id'] === 3)
                                <a href="{{ route('workshop.exercise3') }}" class="text-primary">Ejercicio {{ $item['id'] }} &raquo;</a>
                            @elseif ($item['id'] === 4)
                                <a href="{{ route('workshop.exercise4') }}" class="text-primary">Ejercicio {{ $item['id'] }} &raquo;</a>
                            @elseif ($item['id'] === 5)
                                <a href="{{ route('workshop.exercise5') }}" class="text-primary">Ejercicio {{ $item['id'] }} &raquo;</a>
                            @elseif ($item['id'] === 6)
                                <a href="{{ route('workshop.exercise6') }}" class="text-primary">Ejercicio {{ $item['id'] }} &raquo;</a>
                            @elseif ($item['id'] === 7)
                                <a href="{{ route('workshop.exercise7') }}" class="text-primary">Ejercicio {{ $item['id'] }} &raquo;</a>
                            @elseif ($item['id'] === 8)
                                <a href="{{ route('workshop.exercise8') }}" class="text-primary">Ejercicio {{ $item['id'] }} &raquo;</a>
                            @elseif ($item['id'] === 9)
                                <a href="{{ route('workshop.exercise9') }}" class="text-primary">Ejercicio {{ $item['id'] }} &raquo;</a>
                            @elseif ($item['id'] === 10)
                                <a href="{{ route('workshop.exercise10') }}" class="text-primary">Ejercicio {{ $item['id'] }} &raquo;</a>
                            @elseif ($item['id'] === 11)
                                <a href="{{ route('workshop.exercise11') }}" class="text-primary">Ejercicio {{ $item['id'] }} &raquo;</a>
                            @else
                                Ejercicio {{ $item['id'] }}
                            @endif
                        </h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-{{ $item['color'] }}-light text-{{ $item['color'] }}">
                                <i class="bi {{ $item['icon'] }}"></i>
                            </div>
                            <div class="ps-3">
                                <h6>
                                    @if ($item['id'] === 1)
                                        <a href="{{ route('workshop.exercise1') }}" class="text-dark">{{ $item['title'] }}</a>
                                    @elseif ($item['id'] === 2)
                                        <a href="{{ route('workshop.exercise2') }}" class="text-dark">{{ $item['title'] }}</a>
                                    @elseif ($item['id'] === 3)
                                        <a href="{{ route('workshop.exercise3') }}" class="text-dark">{{ $item['title'] }}</a>
                                    @elseif ($item['id'] === 4)
                                        <a href="{{ route('workshop.exercise4') }}" class="text-dark">{{ $item['title'] }}</a>
                                    @elseif ($item['id'] === 5)
                                        <a href="{{ route('workshop.exercise5') }}" class="text-dark">{{ $item['title'] }}</a>
                                    @elseif ($item['id'] === 6)
                                        <a href="{{ route('workshop.exercise6') }}" class="text-dark">{{ $item['title'] }}</a>
                                    @elseif ($item['id'] === 7)
                                        <a href="{{ route('workshop.exercise7') }}" class="text-dark">{{ $item['title'] }}</a>
                                    @elseif ($item['id'] === 8)
                                        <a href="{{ route('workshop.exercise8') }}" class="text-dark">{{ $item['title'] }}</a>
                                    @elseif ($item['id'] === 9)
                                        <a href="{{ route('workshop.exercise9') }}" class="text-dark">{{ $item['title'] }}</a>
                                    @elseif ($item['id'] === 10)
                                        <a href="{{ route('workshop.exercise10') }}" class="text-dark">{{ $item['title'] }}</a>
                                    @elseif ($item['id'] === 11)
                                        <a href="{{ route('workshop.exercise11') }}" class="text-dark">{{ $item['title'] }}</a>
                                    @else
                                        {{ $item['title'] }}
                                    @endif
                                </h6>
                                <span class="text-muted small pt-2">{{ $item['desc'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</section>
@endsection
