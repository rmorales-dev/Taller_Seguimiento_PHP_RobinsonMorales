@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Ejercicio 3: Generador de Contraseñas Seguras</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('workshop.index') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Ejercicio 3</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <!-- Opciones de configuración -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Configuración de la Contraseña</h5>

                    @if ($errorMessage)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-1"></i> {{ $errorMessage }}
                        </div>
                    @endif

                    <form action="{{ route('workshop.exercise3') }}" method="POST">
                        @csrf

                        <!-- Longitud -->
                        <div class="mb-3">
                            <label for="password_length" class="form-label">
                                Longitud: <span class="fw-bold text-primary" id="lengthDisplay">{{ $passwordLength }}</span> caracteres
                            </label>
                            <input type="range" class="form-range" min="6" max="32" id="password_length" name="password_length" 
                                value="{{ $passwordLength }}" oninput="document.getElementById('lengthDisplay').innerText = this.value">
                        </div>

                        <!-- Tipos de caracteres -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Incluir caracteres:</label>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="include_uppercase" name="include_uppercase" value="1" {{ $includeUppercase ? 'checked' : '' }}>
                                <label class="form-check-label" for="include_uppercase">
                                    Mayúsculas <span class="text-muted small">(A-Z)</span>
                                </label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="include_lowercase" name="include_lowercase" value="1" {{ $includeLowercase ? 'checked' : '' }}>
                                <label class="form-check-label" for="include_lowercase">
                                    Minúsculas <span class="text-muted small">(a-z)</span>
                                </label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="include_numbers" name="include_numbers" value="1" {{ $includeNumbers ? 'checked' : '' }}>
                                <label class="form-check-label" for="include_numbers">
                                    Números <span class="text-muted small">(0-9)</span>
                                </label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="include_symbols" name="include_symbols" value="1" {{ $includeSymbols ? 'checked' : '' }}>
                                <label class="form-check-label" for="include_symbols">
                                    Símbolos especiales <span class="text-muted small">(!@#$%^&*)</span>
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-warning w-100 text-dark fw-semibold">
                            <i class="bi bi-arrow-repeat me-1"></i> Generar Contraseña
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Resultado generado -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Contraseña Resultante</h5>

                    @if ($generatedPassword)
                        <div class="mb-3">
                            <label class="form-label">Tu nueva contraseña:</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-lg fw-bold text-center bg-light" 
                                    id="generatedInput" value="{{ $generatedPassword }}" readonly>
                                <button class="btn btn-outline-primary" type="button" onclick="copyPassword()" title="Copiar">
                                    <i class="bi bi-clipboard"></i> Copiar
                                </button>
                            </div>
                            <span id="copyFeedback" class="small text-success d-none mt-1 d-block">
                                <i class="bi bi-check2"></i> ¡Copiada al portapapeles!
                            </span>
                        </div>

                        <div class="alert alert-success mt-3" role="alert">
                            <i class="bi bi-shield-check me-1"></i> Contraseña de <strong>{{ strlen($generatedPassword) }}</strong> caracteres generada de forma aleatoria con PHP.
                        </div>
                    @else
                        <div class="alert alert-secondary text-center my-4" role="alert">
                            <i class="bi bi-info-circle me-1"></i> Ajusta las opciones y presiona <strong>"Generar Contraseña"</strong> para obtener una clave segura.
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    function copyPassword() {
        const input = document.getElementById('generatedInput');
        if (input) {
            navigator.clipboard.writeText(input.value);
            const feedback = document.getElementById('copyFeedback');
            if (feedback) {
                feedback.classList.remove('d-none');
                setTimeout(() => feedback.classList.add('d-none'), 2500);
            }
        }
    }
</script>
@endpush
@endsection
