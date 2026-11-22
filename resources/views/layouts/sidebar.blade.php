<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('workshop.index') ? '' : 'collapsed' }}" href="{{ route('workshop.index') }}">
                <i class="bi bi-grid"></i>
                <span>Inicio - Taller</span>
            </a>
        </li>

        <li class="nav-heading">Ejercicios</li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('workshop.exercise1') ? '' : 'collapsed' }}" href="{{ route('workshop.exercise1') }}">
                <i class="bi bi-check2-square"></i>
                <span>1. Lista de Tareas</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('workshop.exercise2') ? '' : 'collapsed' }}" href="{{ route('workshop.exercise2') }}">
                <i class="bi bi-calculator"></i>
                <span>2. Calc. Propinas</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('workshop.exercise3') ? '' : 'collapsed' }}" href="{{ route('workshop.exercise3') }}">
                <i class="bi bi-key"></i>
                <span>3. Contraseñas</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('workshop.exercise4') ? '' : 'collapsed' }}" href="{{ route('workshop.exercise4') }}">
                <i class="bi bi-cash-stack"></i>
                <span>4. Gestor de Gastos</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('workshop.exercise5') ? '' : 'collapsed' }}" href="{{ route('workshop.exercise5') }}">
                <i class="bi bi-calendar-check"></i>
                <span>5. Reservas</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('workshop.exercise6') ? '' : 'collapsed' }}" href="{{ route('workshop.exercise6') }}">
                <i class="bi bi-journal-text"></i>
                <span>6. Gestor de Notas</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#">
                <i class="bi bi-calendar-event"></i>
                <span>7. Eventos</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#">
                <i class="bi bi-egg-fried"></i>
                <span>8. Recetas</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#">
                <i class="bi bi-controller"></i>
                <span>9. Juego de Memoria</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#">
                <i class="bi bi-card-checklist"></i>
                <span>10. Encuestas</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#">
                <i class="bi bi-stopwatch"></i>
                <span>11. Cronómetro</span>
            </a>
        </li>

    </ul>

</aside>
