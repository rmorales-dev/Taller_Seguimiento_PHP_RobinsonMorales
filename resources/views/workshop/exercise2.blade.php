@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Ejercicio 2: Calculadora de Propinas</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('workshop.index') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Ejercicio 2</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <!-- Formulario de cálculo -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Datos de la Cuenta</h5>

                    <form action="{{ route('workshop.exercise2') }}" method="POST">
                        @csrf

                        <!-- Monto de la cuenta -->
                        <div class="mb-3">
                            <label for="bill_amount" class="form-label">Total de la cuenta ($)</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" min="0" class="form-control" id="bill_amount" name="bill_amount" 
                                    value="{{ old('bill_amount', $billAmount) }}" placeholder="Ej: 50000" required autofocus>
                            </div>
                        </div>

                        <!-- Porcentaje de propina -->
                        <div class="mb-3">
                            <label class="form-label">Porcentaje de propina</label>
                            <div class="d-flex flex-wrap gap-3 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tip_percentage" id="tip10" value="10" {{ $tipPercentage == 10 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tip10">10%</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tip_percentage" id="tip15" value="15" {{ $tipPercentage == 15 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tip15">15%</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tip_percentage" id="tip20" value="20" {{ $tipPercentage == 20 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tip20">20%</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tip_percentage" id="tip_custom" value="custom" {{ !in_array($tipPercentage, [10, 15, 20]) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tip_custom">Otro</label>
                                </div>
                            </div>

                            <input type="number" step="1" min="0" max="100" class="form-control" id="custom_percentage" 
                                name="custom_percentage" value="{{ $customPercentage ?? (!in_array($tipPercentage, [10, 15, 20]) ? $tipPercentage : '') }}" 
                                placeholder="Escribe otro porcentaje (%)">
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-calculator me-1"></i> Calcular Propina
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tarjeta de resultados -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Resumen del Pago</h5>

                    @if ($calculated)
                        <div class="table-responsive">
                            <table class="table table-bordered mt-2">
                                <tbody>
                                    <tr>
                                        <th class="w-50">Subtotal de la cuenta:</th>
                                        <td class="text-end fw-semibold">${{ number_format($billAmount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Propina ({{ $tipPercentage }}%):</th>
                                        <td class="text-end text-success fw-semibold">+ ${{ number_format($tipAmount, 2) }}</td>
                                    </tr>
                                    <tr class="table-light">
                                        <th class="fs-5">Total a pagar:</th>
                                        <td class="text-end fs-5 fw-bold text-primary">${{ number_format($totalAmount, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="alert alert-success mt-3" role="alert">
                            <i class="bi bi-check-circle me-1"></i> El valor sugerido para la propina es de <strong>${{ number_format($tipAmount, 2) }}</strong>.
                        </div>
                    @else
                        <div class="alert alert-secondary text-center my-4" role="alert">
                            <i class="bi bi-info-circle me-1"></i> Ingresa el monto de la cuenta y selecciona el porcentaje para ver el desglose del total.
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
