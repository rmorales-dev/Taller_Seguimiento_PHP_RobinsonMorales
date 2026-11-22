@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Ejercicio 4: Gestor de Gastos</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('workshop.index') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Ejercicio 4</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <!-- Formulario para agregar gasto -->
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Registrar Gasto</h5>

                    <form action="{{ route('workshop.exercise4') }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="add">

                        <!-- Descripción -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <input type="text" class="form-control" id="description" name="description" placeholder="Ej: Almuerzo universitario" required autofocus>
                        </div>

                        <!-- Monto -->
                        <div class="mb-3">
                            <label for="amount" class="form-label">Monto ($)</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" min="0" class="form-control" id="amount" name="amount" placeholder="Ej: 15000" required>
                            </div>
                        </div>

                        <!-- Categoría -->
                        <div class="mb-3">
                            <label for="category" class="form-label">Categoría</label>
                            <select class="form-select" id="category" name="category" required>
                                <option value="Alimentación">Alimentación</option>
                                <option value="Transporte">Transporte</option>
                                <option value="Educación">Educación</option>
                                <option value="Entretenimiento">Entretenimiento</option>
                                <option value="Salud">Salud</option>
                                <option value="Varios">Varios</option>
                            </select>
                        </div>

                        <!-- Fecha -->
                        <div class="mb-3">
                            <label for="expense_date" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="expense_date" name="expense_date" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-plus-circle me-1"></i> Guardar Gasto
                        </button>
                    </form>
                </div>
            </div>

            <!-- Resumen por categoría -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Resumen por Categoría</h5>

                    @if (empty($categoryTotals))
                        <p class="text-muted small mb-0">Sin datos de gastos aún.</p>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach ($categoryTotals as $catName => $catAmount)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $catName }}
                                    <span class="fw-semibold text-danger">${{ number_format($catAmount, 2) }}</span>
                                </li>
                            @endforeach
                            <li class="list-group-item d-flex justify-content-between align-items-center table-light fw-bold">
                                Total General
                                <span class="text-primary fs-6">${{ number_format($totalSpent, 2) }}</span>
                            </li>
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tabla de gastos registrados -->
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Listado de Gastos</h5>

                    @if (empty($expenses))
                        <div class="alert alert-info text-center my-3" role="alert">
                            <i class="bi bi-info-circle me-1"></i> No has registrado gastos todavía. Registra el primero desde el formulario.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Descripción</th>
                                        <th>Categoría</th>
                                        <th class="text-end">Monto</th>
                                        <th class="text-center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($expenses as $expense)
                                        <tr>
                                            <td class="small text-muted">{{ $expense['date'] }}</td>
                                            <td class="fw-semibold">{{ $expense['description'] }}</td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $expense['category'] }}</span>
                                            </td>
                                            <td class="text-end fw-semibold text-danger">
                                                ${{ number_format($expense['amount'], 2) }}
                                            </td>
                                            <td class="text-center">
                                                <form action="{{ route('workshop.exercise4') }}" method="POST" onsubmit="return confirm('¿Eliminar este gasto?');" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="expense_id" value="{{ $expense['id'] }}">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                                        <i class="bi bi-trash"></i>
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
