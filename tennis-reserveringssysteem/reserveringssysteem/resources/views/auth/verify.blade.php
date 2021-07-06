@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">E-mailadres bevestigen</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            Er is een verificatielink naar uw e-mailadres verstuurd.
                        </div>
                    @endif

                    Controleer voordat u doorgaat uw email op een verificatielink.
                    Als u geen mail hebt ontvangen
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">Klik hier om een nieuwe mail te ontvangen</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
