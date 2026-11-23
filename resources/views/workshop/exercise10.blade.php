@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Ejercicio 10: Plataforma de Encuestas</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('workshop.index') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Ejercicio 10</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <!-- Formulario para crear una nueva encuesta -->
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Crear Encuesta</h5>

                    <form action="{{ route('workshop.exercise10') }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="create">

                        <div class="mb-3">
                            <label for="question" class="form-label">Pregunta</label>
                            <input type="text" class="form-control" id="question" name="question" placeholder="Ej: ¿Qué base de datos prefieres?" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="options_text" class="form-label">Opciones de respuesta</label>
                            <textarea class="form-control" id="options_text" name="options_text" rows="4" placeholder="Escribe una opción por cada línea.&#10;Ejemplo:&#10;MySQL&#10;PostgreSQL&#10;SQLite" required></textarea>
                            <small class="text-muted">Ingresa al menos 2 opciones (una por línea).</small>
                        </div>

                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-plus-circle me-1"></i> Publicar Encuesta
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Listado de encuestas para votar y ver resultados -->
        <div class="col-lg-7">
            @if (empty($surveys))
                <div class="card">
                    <div class="card-body text-center py-4 text-muted">
                        <i class="bi bi-card-checklist fs-1 d-block mb-2"></i>
                        No hay encuestas disponibles en este momento.
                    </div>
                </div>
            @else
                @foreach ($surveys as $survey)
                    @php
                        $totalVotes = array_sum(array_column($survey['options'], 'votes'));
                    @endphp

                    <div class="card mb-3">
                        <div class="card-body pt-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="card-title p-0 m-0 fw-bold text-dark fs-6">{{ $survey['question'] }}</h6>
                                <form action="{{ route('workshop.exercise10') }}" method="POST" onsubmit="return confirm('¿Eliminar esta encuesta?');">
                                    @csrf
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="survey_id" value="{{ $survey['id'] }}">
                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0" title="Eliminar encuesta">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>

                            <p class="text-muted small mb-3">
                                Total de votos acumulados: <strong>{{ $totalVotes }}</strong>
                            </p>

                            <!-- Formulario de votación -->
                            <form action="{{ route('workshop.exercise10') }}" method="POST" class="mb-3">
                                @csrf
                                <input type="hidden" name="action" value="vote">
                                <input type="hidden" name="survey_id" value="{{ $survey['id'] }}">

                                <div class="list-group mb-2">
                                    @foreach ($survey['options'] as $opt)
                                        <label class="list-group-item d-flex align-items-center" style="cursor: pointer;">
                                            <input class="form-check-input me-2" type="radio" name="option_id" value="{{ $opt['id'] }}" required>
                                            <span>{{ $opt['text'] }}</span>
                                        </label>
                                    @endforeach
                                </div>

                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="bi bi-check2-circle me-1"></i> Votar
                                </button>
                            </form>

                            <!-- Informe de resultados con barras de progreso -->
                            <div class="border-top pt-3">
                                <span class="small fw-semibold text-secondary d-block mb-2">
                                    <i class="bi bi-bar-chart-fill me-1"></i> Resultados actuales:
                                </span>

                                @foreach ($survey['options'] as $opt)
                                    @php
                                        $percent = ($totalVotes > 0) ? round(($opt['votes'] / $totalVotes) * 100, 1) : 0;
                                    @endphp
                                    <div class="mb-2">
                                        <div class="d-flex justify-content-between small text-muted mb-1">
                                            <span>{{ $opt['text'] }}</span>
                                            <span>{{ $opt['votes'] }} votos ({{ $percent }}%)</span>
                                        </div>
                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
@endsection
