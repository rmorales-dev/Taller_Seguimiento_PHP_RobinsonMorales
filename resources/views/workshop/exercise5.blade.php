@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Ejercicio 5: Sistema de Reservas</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('workshop.index') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Ejercicio 5</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <!-- Formulario de reserva -->
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Reservar Cita o Servicio</h5>

                    @if ($error)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-x-circle me-1"></i> {{ $error }}
                        </div>
                    @endif

                    @if ($message)
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-1"></i> {{ $message }}
                        </div>
                    @endif

                    <form action="{{ route('workshop.exercise5') }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="book">

                        <!-- Nombre -->
                        <div class="mb-3">
                            <label for="client_name" class="form-label">Nombre del cliente</label>
                            <input type="text" class="form-control" id="client_name" name="client_name" placeholder="Ej: Robinson Morales" required autofocus>
                        </div>

                        <!-- Servicio -->
                        <div class="mb-3">
                            <label for="service" class="form-label">Servicio</label>
                            <select class="form-select" id="service" name="service" required>
                                <option value="Asesoría Técnica">Asesoría Técnica</option>
                                <option value="Mantenimiento de Software">Mantenimiento de Software</option>
                                <option value="Consulta General">Consulta General</option>
                                <option value="Revisión de Proyecto">Revisión de Proyecto</option>
                            </select>
                        </div>

                        <!-- Fecha -->
                        <div class="mb-3">
                            <label for="date" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="date" name="date" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <!-- Horario disponible -->
                        <div class="mb-3">
                            <label for="time" class="form-label">Horario</label>
                            <select class="form-select" id="time" name="time" required>
                                @foreach ($availableHours as $hour)
                                    <option value="{{ $hour }}">{{ $hour }} hrs</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-info w-100 text-white fw-semibold">
                            <i class="bi bi-calendar-check me-1"></i> Confirmar Reserva
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Lista de citas reservadas -->
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Citas Programadas</h5>

                    @if (empty($reservations))
                        <div class="alert alert-info text-center my-3" role="alert">
                            <i class="bi bi-info-circle me-1"></i> No hay reservas registradas en este momento.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Cliente</th>
                                        <th>Servicio</th>
                                        <th class="text-center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reservations as $res)
                                        <tr>
                                            <td class="fw-semibold">{{ $res['date'] }}</td>
                                            <td>
                                                <span class="badge bg-primary">{{ $res['time'] }}</span>
                                            </td>
                                            <td>{{ $res['client_name'] }}</td>
                                            <td class="small text-muted">{{ $res['service'] }}</td>
                                            <td class="text-center">
                                                <form action="{{ route('workshop.exercise5') }}" method="POST" onsubmit="return confirm('¿Cancelar esta reserva?');" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="action" value="cancel">
                                                    <input type="hidden" name="reservation_id" value="{{ $res['id'] }}">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Cancelar cita">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
