@extends('layouts.app')

@section('content')

<div class="container">
    <div class="card-body">
        <div class="card mb-3">
            <div class="card-header">
                {{ $ticket->submitting_user->name }}
                <em>{{ $ticket->created_at->toFormattedDateString() }}</em>
            </div>

            <div class="card-body">
                <h5 class="card_title">
                    <a href="{{ route('ticket_show', ['id' => $ticket]) }}">
                        {{ $ticket->title }}
                    </a>
                </h5>
                <p class="card-text">
                    {!! nl2br(e($ticket->description))!!}
                </p>
            </div>

            <div class="card-footer">
                {{ $ticket->status->description }}
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error_delegate'))
            <div class="alert alert-danger">
                {{ session('error_delegate') }}
            </div>
        @endif

        <div>
            @can ('close', $ticket)
                <form action="{{ route('ticket_close', ['id' => $ticket]) }}" method="POST" class="d-inline">
                    @method('PUT')
                    @csrf

                    <button type="submit" class="btn btn-primary">
                        {{ __('Close Ticket') }}
                    </button>
                </form>
            @endcan

            @can ('claim', $ticket)
                <form action="{{ route('ticket_claim', ['id' => $ticket]) }}" method="POST" class="d-inline">
                    @method('PUT')
                    @csrf

                    <button type="submit" class="btn btn-primary">
                        {{ __('Claim Ticket') }}
                    </button>
                </form>
            @endcan

            @can ('free', $ticket)
                <form action="{{ route('ticket_free', ['id' => $ticket]) }}" method="POST" class="d-inline">
                    @method('PUT')
                    @csrf

                    <button type="submit" class="btn btn-primary">
                        {{ __('Free Ticket') }}
                    </button>
                </form>
            @endcan

            @can ('escalate', $ticket)
                <form action="{{ route('ticket_escalate', ['id' => $ticket]) }}" method="POST" class="d-inline">
                    @method('PUT')
                    @csrf

                    <button type="submit" class="btn btn-primary">
                        {{ __('Escalate Ticket') }}
                    </button>
                </form>
            @endcan

            @can ('deescalate', $ticket)
                <form action="{{ route('ticket_deescalate', ['id' => $ticket]) }}" method="POST" class="d-inline">
                    @method('PUT')
                    @csrf

                    <button type="submit" class="btn btn-primary">
                        {{ __('Deëscalate Ticket') }}
                    </button>
                </form>
            @endcan

            @can ('delegate', $ticket)
                <button type="button" class="btn btn-primary d-inline" data-toggle="modal" data-target="#delegateModal">
                    {{ __('Delegate') }}
                </button>
            @endcan
        </div>


        <div id="comments">
            <div class="card_body">
                @forelse ($ticket->comments as $comment)
                <div class="card">
                    <div class="card-header">
                        {{ __('Comments') }}
                    </div>

                    <div class="card mb-3">
                        <div class="card-header">
                            {{ $comment->submitting_user->name }}
                        </div>

                        <div class="card-body">
                            <p class="card-text">
                                {!! nl2br(e($comment->contents))!!}
                            </p>
                        </div>

                        <div class="card-footer">
                            <em>{{ $comment->created_at->toFormattedDateString() }}</em>
                        </div>
                    </div>
                @empty

                    <p>
                        {{ __('No comments') }}
                    </p>

                @endforelse
            </div>
        </div>

        @can ('comment', $ticket)
            <div class="card">
                <div class="card-header">{{ __('New Comment') }}</div>

                <div class="card-body">
                    <form method="POST" id="form" action="{{ route('comment_save', ['id' => $ticket]) }}">
                        @csrf

                        <div class="form-group row">
                            <label for="contents" class="col-md-4 col-form-label text-md-right">{{ __('Content') }}</label>

                            <div class="col-md-6">
                                <textarea name="contents" id="contents" cols="44" rows="4" class="form-control @error('contents') is-invalid @enderror" autocomplete="contents">{{ old('contents') }}</textarea>

                                @error('contents')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save Comment') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endcan
    </div>
</div>

@can ('delegate', $ticket)
    <div class="modal fade" id="delegateModal" tabindex="-1" role="dialog" aria-labelledby="Delegate ticket" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Delegate Ticket
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="form" action="{{ route('ticket_delegate', $ticket) }}">
                        @method('PUT')
                        @csrf

                        <select name="colleague_id" id="colleague_id" class="form-group">
                            @foreach ($users as $delegatable_user)
                                <option value="{{ $delegatable_user->id }}">{{ $delegatable_user->name }}</option>
                            @endforeach
                        </select>

                        <div class="form-group row mb-0">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Delegate Ticket') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endcan

@endsection
