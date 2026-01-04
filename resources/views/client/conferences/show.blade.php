@extends('layouts.app')

@section('content')
<div class="d-flex align-items-start justify-content-between flex-wrap gap-2 mb-4">
    <div>
        <h1 class="h3 mb-1">{{ $conference->title }}</h1>
        <div class="text-muted">{{ __('app.client.details_subtitle') }}</div>
    </div>

    <div class="d-flex gap-2">
        <a class="btn btn-outline-primary" href="{{ route('client.conferences.index') }}">
            {{ __('app.common.back') }}
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-outline-secondary" type="submit">
                {{ __('app.nav.logout') }}
            </button>
        </form>
    </div>
</div>

<div class="row g-3">
    <div class="col-12 col-lg-7">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title mb-3">{{ __('app.client.conference_info') }}</h5>

                <div class="mb-2">
                    <div class="text-muted small">{{ __('app.conference.description') }}</div>
                    <div>{{ $conference->description }}</div>
                </div>

                <div class="mb-2">
                    <div class="text-muted small">{{ __('app.conference.speakers') }}</div>
                    <div>{{ $conference->speakers }}</div>
                </div>

                <div class="d-flex gap-2 flex-wrap mt-3">
                    <span class="badge bg-light text-dark">{{ __('app.conference.date') }}: {{ $conference->date }}</span>
                    <span class="badge bg-light text-dark">{{ __('app.conference.time') }}: {{ $conference->time }}</span>
                    <span class="badge bg-light text-dark">{{ __('app.conference.address') }}: {{ $conference->address }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3">{{ __('app.conference.register') }}</h5>

                @if($alreadyRegistered)
                    <div class="alert alert-info mb-0">
                        Jūs jau užsiregistravote į šią konferenciją.
                    </div>
                @else
                    <form method="POST" action="{{ route('client.conferences.register', $conference->id) }}">
                        @csrf
                        <button class="btn btn-primary w-100" type="submit">
                            {{ __('app.conference.register') }}
                        </button>
                    </form>

                    <div class="text-muted small mt-3">
                        {{ __('app.client.register_hint') }}
                    </div>
                @endif
            </div>

            <hr class="my-4">

        <div class="d-grid gap-2">
            <form method="POST" action="{{ route('login.as_admin') }}">
                @csrf
                <button class="btn btn-outline-danger w-100" type="submit">
                    Prisijungti kaip administratorius (demo)
                </button>
            </form>

            <form method="POST" action="{{ route('login.as_employee') }}">
                @csrf
                <button class="btn btn-outline-secondary w-100" type="submit">
                    Prisijungti kaip darbuotojas (demo)
                </button>
            </form>
        </div>

        </div>
    </div>
</div>
@endsection