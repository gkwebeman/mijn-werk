@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-center">
            <div class="card col-md-8">
                <div class="card-body">
                    <h3 class="text-center mb-3">
                        Registreren
                    </h3>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="firstname">Voornaam</label>

                                    <div>
                                        <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}" placeholder="Voornaam" autocomplete="firstname" autofocus>

                                        @error('firstname')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="prefix">Tussenvoegsel</label>

                                    <div>
                                        <input id="prefix" type="text" class="form-control @error('prefix') is-invalid @enderror" name="prefix" value="{{ old('prefix') }}" placeholder="Tussenvoegsel" autocomplete="prefix" autofocus>

                                        @error('prefix')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="lastname">Achternaam</label>

                                    <div>
                                        <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" placeholder="Achternaam"  autocomplete="lastname" autofocus>

                                        @error('lastname')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email">E-mailadres</label>

                                    <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" @if(old('email')) value="{{ old('email') }}" @endif id="username" placeholder="E-mailadres" autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label for="password">Wachtwoord</label>

                                    <div>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Wachtwoord" autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password-confirm">Wachtwoord bevestiging</label>

                                    <div>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="clubNumber">Clubnummer</label>

                                    <div>
                                        <input id="clubNumber" type="text" class="form-control @error('clubNumber') is-invalid @enderror" name="clubNumber" value="{{ old('clubNumber') }}" placeholder="Clubnummer" autocomplete="clubNumber" autofocus>

                                        @error('clubNumber')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="member">Lidnummer</label>

                                    <div>
                                        <input id="member" type="text" class="form-control @error('member') is-invalid @enderror" name="member" value="{{ old('member') }}" placeholder="Lidnummer" autocomplete="member" autofocus>

                                        @error('member')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mt-3 mb-3 text-center">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-secondary w-25">
                                    Registreer
                                </button>
                            </div>
                        </div>
                    </form>

                    <p>
                        Heb je al een account? <a href="{{ route('login') }}">Inloggen...</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
