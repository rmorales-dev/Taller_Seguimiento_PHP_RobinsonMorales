@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Ejercicio 8: Plataforma de Recetas</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('workshop.index') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Ejercicio 8</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <!-- Formulario para agregar receta -->
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Nueva Receta de Cocina</h5>

                    <form action="{{ route('workshop.exercise8') }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="add">

                        <div class="mb-3">
                            <label for="title" class="form-label">Nombre del plato</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Ej: Arroz con Pollo Criollo" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="meal_type" class="form-label">Tipo de Comida</label>
                            <select class="form-select" id="meal_type" name="meal_type" required>
                                <option value="Desayuno">Desayuno</option>
                                <option value="Almuerzo" selected>Almuerzo</option>
                                <option value="Cena">Cena</option>
                                <option value="Postre">Postre</option>
                                <option value="Bebida">Bebida</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="ingredients" class="form-label">Ingredientes</label>
                            <textarea class="form-control" id="ingredients" name="ingredients" rows="3" placeholder="Ej: Arroz, pechuga de pollo, zanahoria, cebolla..." required></textarea>
                            <small class="text-muted">Separa los ingredientes por comas o líneas.</small>
                        </div>

                        <div class="mb-3">
                            <label for="instructions" class="form-label">Preparación (Opcional)</label>
                            <textarea class="form-control" id="instructions" name="instructions" rows="2" placeholder="Pasos breves de cocción..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-journal-plus me-1"></i> Guardar Receta
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Buscador y catálogo de recetas -->
        <div class="col-lg-7">
            <!-- Barra de búsqueda y filtro -->
            <div class="card mb-3">
                <div class="card-body py-3">
                    <form action="{{ route('workshop.exercise8') }}" method="GET" class="row g-2 align-items-center">
                        <div class="col-md-7">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="text" class="form-control" name="search" value="{{ $search }}" placeholder="Buscar por ingrediente o plato...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select form-select-sm" name="filter_type">
                                <option value="all" {{ $filterType === 'all' ? 'selected' : '' }}>Todos los tipos</option>
                                <option value="Desayuno" {{ $filterType === 'Desayuno' ? 'selected' : '' }}>Desayuno</option>
                                <option value="Almuerzo" {{ $filterType === 'Almuerzo' ? 'selected' : '' }}>Almuerzo</option>
                                <option value="Cena" {{ $filterType === 'Cena' ? 'selected' : '' }}>Cena</option>
                                <option value="Postre" {{ $filterType === 'Postre' ? 'selected' : '' }}>Postre</option>
                                <option value="Bebida" {{ $filterType === 'Bebida' ? 'selected' : '' }}>Bebida</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex gap-1">
                            <button type="submit" class="btn btn-sm btn-success w-100">Buscar</button>
                            @if (!empty($search) || $filterType !== 'all')
                                <a href="{{ route('workshop.exercise8') }}" class="btn btn-sm btn-outline-secondary" title="Limpiar"><i class="bi bi-x"></i></a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Listado de recetas -->
            @if (empty($recipes))
                <div class="card">
                    <div class="card-body text-center py-4 text-muted">
                        <i class="bi bi-egg fs-1 d-block mb-2"></i>
                        No hay recetas guardadas o ninguna coincide con los filtros de búsqueda.
                    </div>
                </div>
            @else
                <div class="row">
                    @foreach ($recipes as $recipe)
                        <div class="col-md-6 mb-3">
                            <div class="card h-100 border shadow-none">
                                <div class="card-body d-flex flex-column justify-content-between p-3">
                                    <div>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="badge bg-success">{{ $recipe['meal_type'] }}</span>
                                        </div>
                                        <h6 class="card-title p-0 pb-1 m-0 text-dark">{{ $recipe['title'] }}</h6>

                                        <div class="mt-2 small">
                                            <strong>Ingredientes:</strong>
                                            <p class="text-secondary mb-2">{{ $recipe['ingredients'] }}</p>
                                        </div>

                                        @if (!empty($recipe['instructions']))
                                            <div class="small">
                                                <strong>Preparación:</strong>
                                                <p class="text-muted mb-0" style="white-space: pre-line;">{{ $recipe['instructions'] }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="text-end border-top pt-2 mt-3">
                                        <form action="{{ route('workshop.exercise8') }}" method="POST" onsubmit="return confirm('¿Eliminar esta receta?');" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="recipe_id" value="{{ $recipe['id'] }}">
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar receta">
                                                <i class="bi bi-trash"></i> Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</section>
@endsection
