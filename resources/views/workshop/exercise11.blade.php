@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Ejercicio 11: Cronómetro Online</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('workshop.index') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Ejercicio 11</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card text-center">
                <div class="card-body py-4">
                    <h5 class="card-title">Cronómetro con Registro de Vueltas</h5>

                    <!-- Display del cronómetro -->
                    <div class="my-4">
                        <span id="display" class="display-3 fw-bold text-primary font-monospace bg-light p-3 rounded border d-inline-block" style="letter-spacing: 2px;">
                            00:00:00.00
                        </span>
                    </div>

                    <!-- Botones de control -->
                    <div class="d-flex justify-content-center gap-2 mb-4">
                        <button id="btnStart" class="btn btn-success px-4 py-2" onclick="startTimer()">
                            <i class="bi bi-play-fill me-1"></i> Iniciar
                        </button>
                        <button id="btnPause" class="btn btn-warning px-4 py-2 text-dark" onclick="pauseTimer()" disabled>
                            <i class="bi bi-pause-fill me-1"></i> Pausar
                        </button>
                        <button id="btnLap" class="btn btn-info px-4 py-2 text-white" onclick="recordLap()" disabled>
                            <i class="bi bi-flag-fill me-1"></i> Vuelta
                        </button>
                        <button id="btnReset" class="btn btn-danger px-4 py-2" onclick="resetTimer()" disabled>
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reiniciar
                        </button>
                    </div>

                    <!-- Tabla de vueltas -->
                    <div class="card text-start border shadow-none mt-4">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <span class="fw-semibold"><i class="bi bi-list-ol me-1"></i> Registro de Vueltas (Tiempos Parciales)</span>
                            <span id="lapCount" class="badge bg-secondary">0 vueltas</span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
                                <table class="table table-striped table-hover mb-0 text-center">
                                    <thead class="table-light">
                                        <tr>
                                            <th># Vuelta</th>
                                            <th>Tiempo Parcial</th>
                                            <th>Total Acumulado</th>
                                        </tr>
                                    </thead>
                                    <tbody id="lapsTableBody">
                                        <tr id="noLapsRow">
                                            <td colspan="3" class="text-muted py-3">No hay vueltas registradas aún. Presiona "Vuelta" mientras corre el cronómetro.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    let startTime = 0;
    let elapsedTime = 0;
    let timerInterval = null;
    let lapCount = 0;
    let lastLapTime = 0;

    function formatTime(ms) {
        let hours = Math.floor(ms / 3600000);
        let minutes = Math.floor((ms % 3600000) / 60000);
        let seconds = Math.floor((ms % 60000) / 1000);
        let centiseconds = Math.floor((ms % 1000) / 10);

        return (
            (hours < 10 ? "0" + hours : hours) + ":" +
            (minutes < 10 ? "0" + minutes : minutes) + ":" +
            (seconds < 10 ? "0" + seconds : seconds) + "." +
            (centiseconds < 10 ? "0" + centiseconds : centiseconds)
        );
    }

    function startTimer() {
        startTime = Date.now() - elapsedTime;
        timerInterval = setInterval(() => {
            elapsedTime = Date.now() - startTime;
            document.getElementById("display").innerText = formatTime(elapsedTime);
        }, 10);

        document.getElementById("btnStart").disabled = true;
        document.getElementById("btnPause").disabled = false;
        document.getElementById("btnLap").disabled = false;
        document.getElementById("btnReset").disabled = false;
    }

    function pauseTimer() {
        clearInterval(timerInterval);
        document.getElementById("btnStart").disabled = false;
        document.getElementById("btnPause").disabled = true;
        document.getElementById("btnLap").disabled = true;
    }

    function resetTimer() {
        clearInterval(timerInterval);
        elapsedTime = 0;
        lastLapTime = 0;
        lapCount = 0;

        document.getElementById("display").innerText = "00:00:00.00";
        document.getElementById("btnStart").disabled = false;
        document.getElementById("btnPause").disabled = true;
        document.getElementById("btnLap").disabled = true;
        document.getElementById("btnReset").disabled = true;

        document.getElementById("lapCount").innerText = "0 vueltas";
        document.getElementById("lapsTableBody").innerHTML = `
            <tr id="noLapsRow">
                <td colspan="3" class="text-muted py-3">No hay vueltas registradas aún. Presiona "Vuelta" mientras corre el cronómetro.</td>
            </tr>
        `;
    }

    function recordLap() {
        lapCount++;
        let lapSplit = elapsedTime - lastLapTime;
        lastLapTime = elapsedTime;

        let noLapsRow = document.getElementById("noLapsRow");
        if (noLapsRow) {
            noLapsRow.remove();
        }

        let tableBody = document.getElementById("lapsTableBody");
        let row = document.createElement("tr");

        row.innerHTML = `
            <td class="fw-bold">#${lapCount}</td>
            <td class="text-primary font-monospace">+${formatTime(lapSplit)}</td>
            <td class="font-monospace fw-semibold">${formatTime(elapsedTime)}</td>
        `;

        tableBody.insertBefore(row, tableBody.firstChild);
        document.getElementById("lapCount").innerText = lapCount + (lapCount === 1 ? " vuelta" : " vueltas");
    }
</script>
@endpush
@endsection
