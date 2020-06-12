@extends('layouts.app')

@section('content')

<div class="container">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card-body row">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">
                    Assigned tickets
                </div>

                <div class="card-body">

                    @forelse ($assigned_tickets as $assigned_ticket)

                        <div class="card mb-3">
                            <div class="card-header">
                                {{ $assigned_ticket->submitting_user->name }}
                                <em>{{ $assigned_ticket->created_at->toFormattedDateString() }}</em>
                            </div>

                            <div class="card-body">
                                <h5 class="card_title">
                                    @can ('show', $assigned_ticket)
                                        <a href="{{ route('ticket_show', ['id' => $assigned_ticket]) }}">
                                            {{ $assigned_ticket->title }}
                                        </a>
                                    @else
                                        {{ $assigned_ticket->title }}
                                    @endcan
                                </h5>
                                <p class="card-text">
                                    {!! nl2br(e($assigned_ticket->description))!!}
                                </p>
                            </div>

                            <div class="card-footer">
                                {{ $assigned_ticket->status->description }}
                            </div>
                        </div>

                    @empty

                        {{ __('No tickets available...') }}

                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">
                    Unassigned tickets
                </div>

                <div class="card-body">

                    @forelse ($unassigned_tickets as $unassigned_ticket)

                        <div class="card mb-3">
                            <div class="card-header">
                                {{ $unassigned_ticket->submitting_user->name }}
                                <em>{{ $unassigned_ticket->created_at->toFormattedDateString() }}</em>
                            </div>

                            <div class="card-body">
                                <h5 class="card_title">
                                    @can ('show', $unassigned_ticket)
                                        <a href="{{ route('ticket_show', ['id' => $unassigned_ticket]) }}">
                                            {{ $unassigned_ticket->title }}
                                        </a>
                                    @else
                                        {{ $unassigned_ticket->title }}
                                    @endcan
                                </h5>
                                <p class="card-text">
                                    {!! nl2br(e($unassigned_ticket->description))!!}
                                </p>
                            </div>

                            <div class="card-footer">
                                {{ $unassigned_ticket->status->description }}
                            </div>
                        </div>

                    @empty

                        {{ __('No tickets available...') }}

                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
