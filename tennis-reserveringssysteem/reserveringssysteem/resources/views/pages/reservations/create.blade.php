@extends('layouts.app')

@section('content')

<div class="container">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row title-wrap">
        <div class="col-md-12">
            <h1>
                Reserveren
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <form action="{{ route('reservation.store', ['information' => $information]) }}" class="form-horizontal mt-4 row" method="POST">
            @csrf
                <div class="col">
                    <div class="form-group">
                        <label for="reservationUser">Gereserveerd door:</label>

                        <input type="hidden" value={{ $user->id }} name="userId" id="userId">
                        <div class="font-weight-bold">
                            {{ $user->firstname }}
                            {{ $user->prefix }}
                            {{ $user->lastname }}
                        </div>

                        @error('userId')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="date">Datum:</label>

                        <div class="font-weight-bold">
                            <input type="hidden" value="{{ $information->date->format('Y-m-d') }}" name="date" id="date">
                            {{ $information->date->isoFormat('dddd D MMMM YYYY') }}
                        </div>

                        @error('date')
                            <span class="text-danger" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="time">Tijd:</label>

                        <div class="font-weight-bold">
                            <input type="hidden" value="{{ $information->starttime }}" id="starttime" name="starttime">
                            <input type="hidden" value="{{ $information->endtime }}" id="endtime" name="endtime">
                            {{ $information->starttime->format('H:i') }} - {{ $information->endtime->format('H:i') }}
                        </div>

                        @error('starttime')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        @error('endtime')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="courtType">Baan en type:</label>

                        <div class="font-weight-bold">
                            <input type="hidden" id="courts_id" name="courts_id" value="{{ $information->courts_id }}">
                            {{ $information->courtNumber }} | {{ $information->courtType }}
                        </div>

                        @error('courts_id')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col">
                    @if (Auth::user()->roles_id == 1 || Auth::user()->roles_id == 2)
                        <div class="form-group">
                            <label for="reservationKind">Soort reservering:</label>

                            <div>
                                <select name="reservationKind" id="reservationKind" class="form-control">
                                    @foreach ($reservationsKinds as $kind)
                                        <option value="{{ $kind->id }}" @if(old('reservationKind')) selected @endif>{{ $kind->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group d-none @error('nameEvent') d-block @enderror" id="eventReservation">
                            <label for="nameEvent">Naam evenement:</label>

                            <div>
                                <input type="text" id="nameEvent" name="nameEvent" value="{{ old('nameEvent') }}" class="form-control">

                                @error('nameEvent')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group @if($reservationsKinds->count() == 3) d-none @endif" id="classReservation">
                            {{-- Eventueel later herhaling toevoegen. --}}
                        </div>
                    @endif

                    <div class="form-group @if($reservationsKinds->count() !== 3) d-none @endif @error('nameEvent') d-none @enderror" id="normalReservation">
                        <label for="users">Met welke medespeler(s):</label>

                        <div>
                            <select id="choices-multiple-remove-button" name="users[]" placeholder="Selecteer medespelers" multiple>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->firstname }} {{ $user->prefix }} {{ $user->lastname}} | {{ $user->member }}</option>
                                @endforeach
                            </select>

                            @error('users')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    @if (Auth::user()->roles_id == 3)
                        <input type="hidden" name="reservationKind" value="1">
                    @endif

                    <div class="form-group">
                        <input type="submit" value="opslaan" class="btn btn-secondary">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
