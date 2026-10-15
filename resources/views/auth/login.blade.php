@extends('layouts.app')
@section('title', 'Login')
@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <section class="flexbox-container">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="col-md-4 col-10 box-shadow-2 p-0">
                        <div class="card border-grey border-lighten-3 m-0">
                            <div class="mt-3">
                                <div class="card-title text-center">
                                    <div class="p-1">
                                        <img src="{{ asset('img/login.png') }}" alt="branding logo">
                                    </div>
                                </div>
                                <h5 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                                    <span><b>ENTREGA DE EPP</b></span>
                                </h5>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <input id="email" type="email" placeholder="Usuario"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    name="email" value="{{ old('email') }}" required
                                                    autocomplete="email" autofocus>

                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row mt-4">
                                            <div class="col-md-12">
                                                <input id="password" type="password" placeholder="Contraseña"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password" required autocomplete="current-password">
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0 mt-4">
                                            <div class="col-md-12 offset-md-12">
                                                <button type="submit" class="btn btn-danger form-control">
                                                    {{ __('Login') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="">
                                    <p class="float-sm-left text-center m-0"><a href="{{ route('password.request') }}"
                                            class="card-link">Restrablecer
                                            contraseña</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
