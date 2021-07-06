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
                Gegevens
                <input type="hidden" id="user_id" value="{{ $user->id }}">
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="firstname" class="font-weight-bold">
                            Voornaam:
                        </label>

                        <div>
                            {{ $user->firstname }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="prefix" class="font-weight-bold">
                            Tussenvoegsel:
                        </label>

                        <div>
                            {{ $user->prefix ?? 'N.V.T' }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="lastname" class="font-weight-bold">
                            Achternaam:
                        </label>

                        <div>
                            {{ $user->lastname }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="member" class="font-weight-bold">
                            Lidnummer:
                        </label>

                        <div>
                            {{ $user->member ?? 'N.V.T' }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="font-weight-bold">
                            E-mailadres:
                        </label>

                        <div>
                            {{ $user->email }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="club" class="font-weight-bold">
                            Clubnummer:
                        </label>

                        <div>
                            {{ $user->club->name }}
                        </div>
                    </div>

                    <button class="btn btn-secondary w-50 mt-2">
                        <a href="{{ route('password.request') }}" class="text-white text-decoration-none">
                            Wachtwoord wijzigen
                        </a>
                    </button>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        @if ($user->picture)
                            <img class="w-25 p-1 userPicture rounded-circle border border-dark" src="{{ route('get_user_image', ['id' => $user->id, 'filename' => $user->picture]) }}" alt="" id="userPicture">

                            <div>
                                <button id="deleteUserPicture" class="deleteUserPictureBtn btn btn-secondary w-25 mt-2">
                                    Verwijder foto
                                </button>
                            </div>

                            <form id="addProfilePhoto" class="mb-0" enctype="multipart/form-data" method="POST" action="{{ route('save_user_image', ['user' => $user]) }}">
                                @csrf
                                @method('PUT')
                                <input type="file" id="addUserPictureFile" name="picture" class="d-none deleteUserPhotoFile">
                            </form>
                        @else
                            <form id="addProfilePhoto" class="mb-0" enctype="multipart/form-data" method="POST" action="{{ route('save_user_image', ['user' => $user]) }}">
                                @csrf
                                @method('PUT')
                                <input id="addNewUserPictureFile" type="file" name="picture">
                            </form>
                        @endif

                        @error('picture')
                            <span class="text-danger d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
