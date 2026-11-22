@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Ejercicio 6: Gestor de Notas</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('workshop.index') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Ejercicio 6</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <!-- Formulario para crear nota -->
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Nueva Nota</h5>

                    <form action="{{ route('workshop.exercise6') }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="add">

                        <div class="mb-3">
                            <label for="title" class="form-label">Título</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Ej: Resumen examen PHP" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Categoría</label>
                            <select class="form-select" id="category" name="category" required>
                                <option value="Universidad">Universidad</option>
                                <option value="Personal">Personal</option>
                                <option value="Trabajo">Trabajo</option>
                                <option value="Ideas">Ideas</option>
                                <option value="General">General</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Contenido de la nota</label>
                            <textarea class="form-control" id="content" name="content" rows="4" placeholder="Escribe aquí el contenido..." required></textarea>
                        </div>

                        <button type="submit" class="btn btn-secondary w-100">
                            <i class="bi bi-save me-1"></i> Guardar Nota
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Buscador y lista de notas -->
        <div class="col-lg-7">
            <!-- Barra de búsqueda y filtro -->
            <div class="card mb-3">
                <div class="card-body py-3">
                    <form action="{{ route('workshop.exercise6') }}" method="GET" class="row g-2 align-items-center">
                        <div class="col-md-7">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="text" class="form-control" name="search" value="{{ $searchQuery }}" placeholder="Buscar por título o texto...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select form-select-sm" name="filter_category">
                                <option value="all" {{ $filteredCategory === 'all' ? 'selected' : '' }}>Todas</option>
                                <option value="Universidad" {{ $filteredCategory === 'Universidad' ? 'selected' : '' }}>Universidad</option>
                                <option value="Personal" {{ $filteredCategory === 'Personal' ? 'selected' : '' }}>Personal</option>
                                <option value="Trabajo" {{ $filteredCategory === 'Trabajo' ? 'selected' : '' }}>Trabajo</option>
                                <option value="Ideas" {{ $filteredCategory === 'Ideas' ? 'selected' : '' }}>Ideas</option>
                                <option value="General" {{ $filteredCategory === 'General' ? 'selected' : '' }}>General</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex gap-1">
                            <button type="submit" class="btn btn-sm btn-primary w-100">Filtrar</button>
                            @if (!empty($searchQuery) || $filteredCategory !== 'all')
                                <a href="{{ route('workshop.exercise6') }}" class="btn btn-sm btn-outline-secondary" title="Limpiar"><i class="bi bi-x"></i></a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Listado de tarjetas de notas -->
            @if (empty($notes))
                <div class="card">
                    <div class="card-body text-center py-4 text-muted">
                        <i class="bi bi-journal-x fs-1 d-block mb-2"></i>
                        No se encontraron notas registradas o coincidentes con la búsqueda.
                    </div>
                </div>
            @else
                <div class="row">
                    @foreach ($notes as $note)
                        <div class="col-md-6 mb-3">
                            <div class="card h-100 border shadow-none">
                                <div class="card-body d-flex flex-column justify-content-between p-3">
                                    <div>
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <span class="badge bg-secondary">{{ $note['category'] }}</span>
                                            <small class="text-muted">{{ $note['created_at'] }}</small>
                                        </div>
                                        <h6 class="card-title p-0 pb-1 m-0 text-dark">{{ $note['title'] }}</h6>
                                        <p class="card-text small text-secondary mt-2 mb-3" style="white-space: pre-line;">
                                            {{ $note['content'] }}
                                        </p>
                                    </div>
                                    <div class="text-end border-top pt-2">
                                        <form action="{{ route('workshop.exercise6') }}" method="POST" onsubmit="return confirm('¿Eliminar esta nota?');" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="note_id" value="{{ $note['id'] }}">
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar nota">
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
