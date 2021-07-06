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
                Gebruikers
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="table-responsive table table-striped table-bordered p-4 ml-4">
                <table class="table mb-0" id="usertable">
                    <thead>
                        <tr>
                            <th>Naam</th>
                            <th>Email</th>
                            <th>Lidnummer</th>
                            <th>Rol</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    {{ $user->firstname }}
                                    {{ $user->prefix }}
                                    {{ $user->lastname }}
                                </td>
                                <td>
                                    {{ $user->email }}
                                </td>
                                <td>
                                    {{ $user->member ?? 'N.V.T' }}
                                </td>
                                <td>
                                    @foreach ($roles as $role)
                                        @if ($role->id == $user->roles_id)
                                            {{ $role->name }}
                                        @endif
                                    @endforeach
                                    @if ($user->roles_id != 1)
                                        <span class="float-right">
                                            <a href="#changeUserRoleModal" name="{{ $user->id }}" data-toggle="modal" id="changeUserRole" data-target="#changeUserRoleModal" class="text-dark">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="changeUserRoleModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Wijzigen gebruiker</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body row">
                <div class="form-group col">
                    <label for="name">Naam:</label>

                    <input name="name" type="text" class="form-control" id="userName" disabled>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col">
                    <label for="roles_id">Rol:</label>

                    <select name="roles_id" id="roles_id" class="form-control">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" id="role">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button id="changeUserRoleBtn" type="button" class="btn btn-dark" data-dismiss="modal">Opslaan</button>

                <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Annuleren</button>
            </div>
        </div>
    </div>
</div>
@endsection
