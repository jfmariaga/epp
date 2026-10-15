<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Entrega EPP')</title>

    {{-- Bootstrap sigue cargado: varios modales/formularios aún no migrados a Tailwind lo necesitan
         para que .modal, .form-control, etc. se vean correctamente mientras se completa la migración --}}
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.2/css/all.min.css">
    @yield('css')
</head>
<body class="bg-slate-50 text-slate-900 antialiased">
    @auth
        @php
            $navLinks = [
                ['route' => 'entrega', 'label' => 'Entrega de EPP', 'icon' => 'fa-hard-hat'],
                ['route' => 'empleado', 'label' => 'Colaborador', 'icon' => 'fa-users'],
                ['route' => 'reportes', 'label' => 'Reportes', 'icon' => 'fa-chart-bar'],
                ['route' => 'inventario', 'label' => 'Items', 'icon' => 'fa-boxes-stacked'],
            ];
        @endphp
        <div class="flex min-h-screen flex-col">
            <header class="bg-slate-900 text-white">
                <div class="flex h-16 items-center justify-between px-4">
                    <a href="{{ route('home') }}" class="text-lg font-bold">EPP · PANAL</a>

                    <nav class="hidden items-center gap-1 md:flex">
                        @foreach ($navLinks as $link)
                            <a href="{{ route($link['route']) }}"
                                class="nav-link-touch {{ request()->routeIs($link['route']) ? 'active' : '' }}">
                                <i class="fas {{ $link['icon'] }}"></i> {{ $link['label'] }}
                            </a>
                        @endforeach
                        @can('manage-users')
                            <a href="{{ route('usuario') }}"
                                class="nav-link-touch {{ request()->routeIs('usuario') ? 'active' : '' }}">
                                <i class="fas fa-user-shield"></i> Usuarios
                            </a>
                        @endcan
                    </nav>

                    <div class="hidden items-center gap-3 md:flex">
                        <span class="text-sm text-slate-300">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn-secondary">
                                <i class="fas fa-sign-out-alt"></i> Salir
                            </button>
                        </form>
                    </div>

                    <button id="nav-toggle" type="button" class="btn-touch min-w-touch text-white md:hidden"
                        aria-label="Abrir menú" aria-expanded="false" aria-controls="mobile-nav">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>

                <nav id="mobile-nav" class="hidden flex-col gap-1 border-t border-slate-800 px-4 py-3 md:hidden">
                    @foreach ($navLinks as $link)
                        <a href="{{ route($link['route']) }}"
                            class="nav-link-touch {{ request()->routeIs($link['route']) ? 'active' : '' }}">
                            <i class="fas {{ $link['icon'] }} w-5"></i> {{ $link['label'] }}
                        </a>
                    @endforeach
                    @can('manage-users')
                        <a href="{{ route('usuario') }}"
                            class="nav-link-touch {{ request()->routeIs('usuario') ? 'active' : '' }}">
                            <i class="fas fa-user-shield w-5"></i> Usuarios
                        </a>
                    @endcan
                    <form method="POST" action="{{ route('logout') }}" class="pt-2">
                        @csrf
                        <button type="submit" class="btn-secondary w-full">
                            <i class="fas fa-sign-out-alt"></i> Salir ({{ auth()->user()->name }})
                        </button>
                    </form>
                </nav>
            </header>

            <main class="flex-1 p-3 md:p-6">
                @if (session('info'))
                    <div class="mb-4 flex items-center justify-between rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
                        <span>{{ session('info') }}</span>
                    </div>
                @endif

                <h1 class="mb-4 text-xl font-bold text-slate-800 md:text-2xl">@yield('content_header')</h1>

                @yield('content')
            </main>
        </div>
    @else
        @yield('content')
    @endauth

    @stack('modals')

    {{-- jQuery + Bootstrap bundle: varios modales/formularios siguen usando $().modal() y
         data-toggle="modal" (patrón heredado de AdminLTE) mientras se completa la migración --}}
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @livewireStyles
    @livewireScripts
    @yield('js')

    <script>
        document.getElementById('nav-toggle')?.addEventListener('click', function () {
            const nav = document.getElementById('mobile-nav');
            const expanded = this.getAttribute('aria-expanded') === 'true';
            nav.classList.toggle('hidden');
            this.setAttribute('aria-expanded', String(!expanded));
        });
    </script>
</body>
</html>
