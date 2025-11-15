<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'MiApp'))</title>

    <!-- Bootstrap 5 CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="" crossorigin="anonymous">

    <style>
        /* Pequeños ajustes para simular el look de la captura */
        body { background: #d0ecf6; }
        .app-shell {
            background: #fff;
            margin: 36px auto;
            border-radius: 6px;
            box-shadow: 0 10px 30px rgba(16, 60, 87, 0.08);
            overflow: hidden;
        }
        .app-header {
            padding: 28px 36px;
            border-bottom: 1px solid #eef2f5;
        }
        .app-header h1 { margin: 0; font-weight: 700; font-size: 34px; }
        .card-link { text-decoration: none; }
        .table-actions .btn { margin-left: .5rem; }
    </style>

    @stack('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="app-shell col-11 mx-auto">
            <header class="app-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <a class="me-3 d-inline-flex align-items-center text-decoration-none" href="{{ route(Route::has('dashboard') ? 'dashboard' : 'equipments.index') }}">
                        <x-application-logo class="me-3" />
                        <!-- Marca fija "MEREY" en la navbar -->
                        <span class="h4 mb-0">MEREY</span>
                    </a>
                    <div class="d-none d-md-block">
                        <a href="{{ route('equipments.index') }}" class="me-3 text-decoration-none">Equipos</a>
                        @auth
                            <a href="{{ route('rentals.index') }}" class="me-3 text-decoration-none">Rentas</a>
                        @endauth
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary me-2">Iniciar sesión</a>
                        @if(Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-outline-secondary me-2">Registrarse</a>
                        @endif
                    @else
                        <div class="dropdown me-2">
                            <button class="btn btn-outline-secondary dropdown-toggle" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ auth()->user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                                <li><a class="dropdown-item" href="{{ route('profile.show') }}">Mi perfil</a></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item" type="submit">Cerrar sesión</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest
                    <!-- Small screen menu button -->
                    <button class="btn btn-outline-secondary d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#mobileNav">
                        ☰
                    </button>
                </div>
            </header>

            <div class="collapse d-md-none" id="mobileNav">
                <div class="p-3 border-bottom">
                    <a href="{{ route('equipments.index') }}" class="d-block mb-2">Equipos</a>
                    @auth
                        <a href="{{ route('rentals.index') }}" class="d-block mb-2">Rentas</a>
                        <a href="{{ route('profile.show') }}" class="d-block mb-2">Perfil</a>
                    @endauth
                </div>
            </div>

            <main class="p-4 p-md-5">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="" crossorigin="anonymous"></script>
    @stack('scripts')
</body>
</html>