@extends('layouts.tailwind')

@section('title', 'Crear cuenta')

@section('content')
    <div class="flex min-h-screen items-center justify-center bg-slate-100 p-4">
        <div class="card-panel w-full max-w-md p-6 md:p-8">
            <div class="mb-6 text-center">
                <img src="{{ asset('img/login.png') }}" alt="Entrega EPP" class="mx-auto mb-3 h-16">
                <h1 class="text-xl font-bold text-slate-800">Crear cuenta</h1>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="name" class="mb-1 block text-sm font-medium text-slate-700">Nombre</label>
                    <input id="name" type="text" class="input-touch @error('name') border-red-500 @enderror"
                        name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="mb-1 block text-sm font-medium text-slate-700">Correo</label>
                    <input id="email" type="email" class="input-touch @error('email') border-red-500 @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="mb-1 block text-sm font-medium text-slate-700">Contraseña</label>
                    <input id="password" type="password" class="input-touch @error('password') border-red-500 @enderror"
                        name="password" required autocomplete="new-password">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password-confirm" class="mb-1 block text-sm font-medium text-slate-700">Confirmar
                        contraseña</label>
                    <input id="password-confirm" type="password" class="input-touch" name="password_confirmation"
                        required autocomplete="new-password">
                </div>

                <button type="submit" class="btn-primary w-full">Registrarme</button>
            </form>
        </div>
    </div>
@endsection
