@extends('layouts.tailwind')

@section('title', 'Iniciar sesión')

@section('content')
    <div class="flex min-h-screen items-center justify-center bg-slate-100 p-4">
        <div class="card-panel w-full max-w-md p-6 md:p-8">
            <div class="mb-6 text-center">
                <img src="{{ asset('img/login.png') }}" alt="Entrega EPP" class="mx-auto mb-3 h-16">
                <h1 class="text-xl font-bold text-slate-800">ENTREGA DE EPP</h1>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="mb-1 block text-sm font-medium text-slate-700">Usuario</label>
                    <input id="email" type="email" placeholder="correo@panalsas.com"
                        class="input-touch @error('email') border-red-500 @enderror" name="email"
                        value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="mb-1 block text-sm font-medium text-slate-700">Contraseña</label>
                    <input id="password" type="password" placeholder="••••••••"
                        class="input-touch @error('password') border-red-500 @enderror" name="password" required
                        autocomplete="current-password">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-primary w-full">Iniciar sesión</button>
            </form>

            <div class="mt-4 text-center">
                <a href="{{ route('password.request') }}" class="text-sm text-brand-600 hover:underline">
                    Restablecer contraseña
                </a>
            </div>
        </div>
    </div>
@endsection
