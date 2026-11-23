@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Ejercicio 9: Juego de Memoria</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('workshop.index') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Ejercicio 9</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Empareja las Cartas</h5>

                        <!-- Selector de Dificultad -->
                        <form action="{{ route('workshop.exercise9') }}" method="GET" class="d-flex align-items-center gap-2">
                            <label class="small text-muted fw-semibold">Dificultad:</label>
                            <select name="difficulty" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="easy" {{ $difficulty === 'easy' ? 'selected' : '' }}>Fácil (4 parejas)</option>
                                <option value="normal" {{ $difficulty === 'normal' ? 'selected' : '' }}>Normal (6 parejas)</option>
                                <option value="hard" {{ $difficulty === 'hard' ? 'selected' : '' }}>Difícil (8 parejas)</option>
                            </select>
                        </form>
                    </div>

                    <!-- Panel de puntaje y turnos -->
                    <div class="row g-2 text-center mb-4">
                        <div class="col-4">
                            <div class="p-2 border rounded bg-light">
                                <span class="small text-muted d-block">Intentos</span>
                                <span id="movesCount" class="fs-5 fw-bold text-dark">0</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 border rounded bg-light">
                                <span class="small text-muted d-block">Parejas encontradas</span>
                                <span id="matchedCount" class="fs-5 fw-bold text-success">0</span> / {{ $totalPairs }}
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 border rounded bg-light">
                                <span class="small text-muted d-block">Puntuación</span>
                                <span id="scoreCount" class="fs-5 fw-bold text-primary">0 pts</span>
                            </div>
                        </div>
                    </div>

                    <!-- Mensaje de victoria -->
                    <div id="victoryAlert" class="alert alert-success text-center d-none" role="alert">
                        <h5 class="alert-heading fw-bold mb-1"><i class="bi bi-trophy-fill me-1"></i> ¡Felicitaciones!</h5>
                        <p class="mb-2">Has completado el juego de memoria con éxito.</p>
                        <a href="{{ route('workshop.exercise9', ['difficulty' => $difficulty]) }}" class="btn btn-sm btn-success">
                            <i class="bi bi-arrow-clockwise"></i> Jugar otra vez
                        </a>
                    </div>

                    <!-- Tablero de cartas -->
                    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-3 justify-content-center" id="board">
                        @foreach ($cards as $index => $card)
                            <div class="col">
                                <div class="card memory-card border text-center p-3 bg-light shadow-sm" 
                                    style="height: 110px; cursor: pointer; user-select: none;"
                                    data-card-id="{{ $card['id'] }}" 
                                    data-icon="{{ $card['icon'] }}" 
                                    onclick="flipCard(this)">
                                    <div class="card-body p-0 d-flex align-items-center justify-content-center h-100">
                                        <i class="bi bi-question-circle text-muted fs-1 card-back"></i>
                                        <i class="bi {{ $card['icon'] }} text-primary fs-1 card-front d-none"></i>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('workshop.exercise9', ['difficulty' => $difficulty]) }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-repeat me-1"></i> Reiniciar Tablero
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    const totalPairs = {{ $totalPairs }};
    let firstCard = null;
    let secondCard = null;
    let lockBoard = false;
    let moves = 0;
    let matches = 0;
    let score = 0;

    function flipCard(cardElement) {
        if (lockBoard) return;
        if (cardElement === firstCard) return;
        if (cardElement.classList.contains('matched')) return;

        // Mostrar cara de la carta
        cardElement.querySelector('.card-back').classList.add('d-none');
        cardElement.querySelector('.card-front').classList.remove('d-none');
        cardElement.classList.remove('bg-light');
        cardElement.classList.add('bg-white', 'border-primary');

        if (!firstCard) {
            firstCard = cardElement;
            return;
        }

        secondCard = cardElement;
        moves++;
        document.getElementById('movesCount').innerText = moves;

        checkForMatch();
    }

    function checkForMatch() {
        const isMatch = firstCard.dataset.icon === secondCard.dataset.icon;

        if (isMatch) {
            disableCards();
        } else {
            unflipCards();
        }
    }

    function disableCards() {
        firstCard.classList.add('matched', 'bg-success-light', 'border-success');
        secondCard.classList.add('matched', 'bg-success-light', 'border-success');
        firstCard.querySelector('.card-front').classList.replace('text-primary', 'text-success');
        secondCard.querySelector('.card-front').classList.replace('text-primary', 'text-success');

        matches++;
        score += 100;
        document.getElementById('matchedCount').innerText = matches;
        document.getElementById('scoreCount').innerText = score + ' pts';

        resetBoard();

        if (matches === totalPairs) {
            setTimeout(() => {
                document.getElementById('victoryAlert').classList.remove('d-none');
            }, 500);
        }
    }

    function unflipCards() {
        lockBoard = true;
        score = Math.max(0, score - 10);
        document.getElementById('scoreCount').innerText = score + ' pts';

        setTimeout(() => {
            firstCard.querySelector('.card-back').classList.remove('d-none');
            firstCard.querySelector('.card-front').classList.add('d-none');
            firstCard.classList.add('bg-light');
            firstCard.classList.remove('bg-white', 'border-primary');

            secondCard.querySelector('.card-back').classList.remove('d-none');
            secondCard.querySelector('.card-front').classList.add('d-none');
            secondCard.classList.add('bg-light');
            secondCard.classList.remove('bg-white', 'border-primary');

            resetBoard();
        }, 900);
    }

    function resetBoard() {
        [firstCard, secondCard] = [null, null];
        lockBoard = false;
    }
</script>
@endpush
@endsection
