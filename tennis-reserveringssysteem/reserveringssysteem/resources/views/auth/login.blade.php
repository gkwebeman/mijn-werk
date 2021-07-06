@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-center">
            <div class="card col-md-5">
                <div class="card-body text-center">
                    <h2 class="mb-3">
                        Inloggen
                    </h2>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                            <label for="email">E-mailadres:</label>

                            <div>
                                <input id="text" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password">Wachtwoord:</label>

                            <div>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-secondary w-50 mt-2">
                                Inloggen
                            </button>
                        </div>

                        <div class="form-group text-left mt-4">
                            @if (Route::has('password.request'))
                               <a href="{{ route('password.request') }}">
                                   Wachtwoord vergeten?
                               </a>
                           @endif
                       </div>

                        <p class='text-left'>
                            Heb je nog geen account? <a href="{{ route('register') }}">Registreren...</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
