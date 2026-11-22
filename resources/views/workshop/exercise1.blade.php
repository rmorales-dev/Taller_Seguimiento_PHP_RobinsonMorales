@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Ejercicio 1: Lista de Tareas</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('workshop.index') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Ejercicio 1</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <!-- Formulario para agregar tarea -->
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Nueva Tarea</h5>

                    <form action="{{ route('workshop.exercise1') }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="add">

                        <div class="mb-3">
                            <label for="task_name" class="form-label">Descripción de la tarea</label>
                            <input type="text" class="form-control" id="task_name" name="task_name" placeholder="Ej: Estudiar para el examen de PHP" required autofocus>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-plus-circle me-1"></i> Agregar Tarea
                        </button>
                    </form>
                </div>
            </div>

            <!-- Resumen de tareas -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Resumen</h5>
                    @php
                        $totalTasks = count($tasks);
                        $completedTasks = count(array_filter($tasks, fn($item) => $item['completed']));
                        $pendingTasks = $totalTasks - $completedTasks;
                    @endphp
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total de tareas
                            <span class="badge bg-primary rounded-pill">{{ $totalTasks }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Pendientes
                            <span class="badge bg-warning text-dark rounded-pill">{{ $pendingTasks }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Completadas
                            <span class="badge bg-success rounded-pill">{{ $completedTasks }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Listado de tareas -->
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Mis Tareas</h5>

                    @if (empty($tasks))
                        <div class="alert alert-info text-center my-3" role="alert">
                            <i class="bi bi-info-circle me-1"></i> No hay tareas registradas todavía. Agrega una desde el formulario.
                        </div>
                    @else
                        <div class="list-group">
                            @foreach ($tasks as $task)
                                <div class="list-group-item d-flex justify-content-between align-items-center py-3 {{ $task['completed'] ? 'list-group-item-light' : '' }}">
                                    <div class="d-flex align-items-center">
                                        <!-- Formulario para alternar completado -->
                                        <form action="{{ route('workshop.exercise1') }}" method="POST" class="me-3">
                                            @csrf
                                            <input type="hidden" name="action" value="toggle">
                                            <input type="hidden" name="task_id" value="{{ $task['id'] }}">
                                            <button type="submit" class="btn btn-sm {{ $task['completed'] ? 'btn-success' : 'btn-outline-secondary' }}" title="Cambiar estado">
                                                <i class="bi {{ $task['completed'] ? 'bi-check-circle-fill' : 'bi-circle' }}"></i>
                                            </button>
                                        </form>

                                        <div>
                                            <span class="{{ $task['completed'] ? 'text-decoration-line-through text-muted' : 'fw-semibold' }}">
                                                {{ $task['name'] }}
                                            </span>
                                            <div class="small text-muted">
                                                Registrada: {{ $task['created_at'] }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Formulario para eliminar tarea -->
                                    <form action="{{ route('workshop.exercise1') }}" method="POST" onsubmit="return confirm('¿Deseas eliminar esta tarea?');">
                                        @csrf
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="task_id" value="{{ $task['id'] }}">
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
