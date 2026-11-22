@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Ejercicio 7: Calendario de Eventos</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('workshop.index') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Ejercicio 7</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <!-- Formulario para agregar evento -->
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Nuevo Evento</h5>

                    <form action="{{ route('workshop.exercise7') }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="add">

                        <div class="mb-3">
                            <label for="title" class="form-label">Nombre del evento</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Ej: Entrega parcial de PHP" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="date" name="date" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="time" class="form-label">Hora</label>
                            <input type="time" class="form-control" id="time" name="time" value="10:00" required>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="reminder" name="reminder" value="1" checked>
                            <label class="form-check-label" for="reminder">
                                Activar recordatorio / notificación visual
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-calendar-plus me-1"></i> Agendar Evento
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Lista cronológica de eventos -->
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Agenda de Eventos (Cronológico)</h5>

                    @if (empty($events))
                        <div class="alert alert-info text-center my-3" role="alert">
                            <i class="bi bi-info-circle me-1"></i> No tienes eventos agendados aún. Agrega el primero desde el formulario.
                        </div>
                    @else
                        <div class="list-group">
                            @foreach ($events as $event)
                                @php
                                    $isToday = ($event['date'] === date('Y-m-d'));
                                    $isPast = ($event['date'] < date('Y-m-d'));
                                @endphp
                                <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3 {{ $isToday ? 'border-primary border-2' : '' }}">
                                    <div class="d-flex align-items-start">
                                        <div class="me-3 text-center p-2 rounded {{ $isToday ? 'bg-primary text-white' : 'bg-light text-dark' }}" style="min-width: 65px;">
                                            <small class="d-block text-uppercase fw-bold">{{ date('M', strtotime($event['date'])) }}</small>
                                            <span class="fs-4 fw-bold">{{ date('d', strtotime($event['date'])) }}</span>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold {{ $isPast ? 'text-muted text-decoration-line-through' : 'text-dark' }}">
                                                {{ $event['title'] }}
                                            </h6>
                                            <div class="small text-muted">
                                                <i class="bi bi-clock me-1"></i> {{ $event['time'] }} hrs
                                                @if ($isToday)
                                                    <span class="badge bg-warning text-dark ms-2">¡Hoy!</span>
                                                @elseif ($isPast)
                                                    <span class="badge bg-secondary ms-2">Finalizado</span>
                                                @endif

                                                @if ($event['reminder'])
                                                    <span class="badge bg-info text-dark ms-1">
                                                        <i class="bi bi-bell-fill"></i> Recordatorio activo
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <form action="{{ route('workshop.exercise7') }}" method="POST" onsubmit="return confirm('¿Eliminar este evento?');">
                                        @csrf
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="event_id" value="{{ $event['id'] }}">
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar evento">
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
