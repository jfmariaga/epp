@extends('layouts.tailwind')

@section('title', 'Generar nueva contraseña')

@section('content')
    <div class="flex min-h-screen items-center justify-center bg-slate-100 p-4">
        <div class="card-panel w-full max-w-md p-6 md:p-8">
            <div class="mb-6 text-center">
                <img src="{{ asset('img/login.png') }}" alt="Entrega EPP" class="mx-auto mb-3 h-16">
                <h1 class="text-lg font-bold text-slate-800">Generar nueva contraseña</h1>
            </div>

            @if (session('status'))
                <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label for="email" class="mb-1 block text-sm font-medium text-slate-700">Correo electrónico</label>
                    <input id="email" type="email" class="input-touch @error('email') border-red-500 @enderror"
                        name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
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

                <button type="submit" class="btn-primary w-full">Restablecer contraseña</button>
            </form>
        </div>
    </div>
@endsection
