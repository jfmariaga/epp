@extends('layouts.app')

@section('content')
<div class="container ">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="p-1 text-center">
                    <img src="{{ asset('img/login.png') }}" alt="branding logo">
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="text-center">
                        <p>Confirma tu dirección de correo electrónico, para poder generar un link de cambio de contraseña (recuerda revisar tu carpeta de Spam algunas veces el email llega a ese buzon)</p>
                              
                    </div>

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">

                            <div class="col-md-12 text-center">
                            

                                <input id="email" type="email" placeholder="Escribe aqui tu correo electrónico" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0 mt-4">
                            <div class="col-md-6  ml-6">
                                <button type="submit" class="btn btn-danger">
                                    {{ __('Restablecer') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
