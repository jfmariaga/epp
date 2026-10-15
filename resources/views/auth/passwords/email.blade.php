@extends('layouts.tailwind')

@section('title', 'Restablecer contraseña')

@section('content')
    <div class="flex min-h-screen items-center justify-center bg-slate-100 p-4">
        <div class="card-panel w-full max-w-md p-6 md:p-8">
            <div class="mb-6 text-center">
                <img src="{{ asset('img/login.png') }}" alt="Entrega EPP" class="mx-auto mb-3 h-16">
            </div>

            @if (session('status'))
                <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
                    {{ session('status') }}
                </div>
            @endif

            <p class="mb-4 text-center text-sm text-slate-600">
                Confirma tu dirección de correo electrónico, para poder generar un link de cambio de contraseña
                (recuerda revisar tu carpeta de Spam, algunas veces el email llega ahí).
            </p>

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                <div>
                    <input id="email" type="email" placeholder="Escribe aquí tu correo electrónico"
                        class="input-touch @error('email') border-red-500 @enderror" name="email"
                        value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-primary w-full">Restablecer</button>
            </form>
        </div>
    </div>
@endsection
