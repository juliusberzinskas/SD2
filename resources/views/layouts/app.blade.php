<!doctype html>
<html lang="lt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', __('app.app_title'))</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

@php
    $auth = session('auth_user');

    $role = $auth['role'] ?? null;

    $roleLabel = match ($role) {
        'admin' => 'Admin',
        'employee' => 'Darbuotojas',
        'client' => 'Klientas',
        default => null,
    };

    $roleBadgeClass = match ($role) {
        'admin' => 'bg-danger',
        'employee' => 'bg-secondary',
        'client' => 'bg-primary',
        default => 'bg-light text-dark',
    };

    $isActive = fn (string $prefix) => request()->routeIs($prefix . '*');
    $navBtnClass = fn (string $prefix) => $isActive($prefix) ? 'btn btn-primary' : 'btn btn-outline-primary';
@endphp

<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container">
        {{-- BRAND visada veda į home --}}
        <a class="navbar-brand fw-semibold" href="{{ route('home') }}">
            {{ __('app.app_title') }}
        </a>

        {{-- Role badge --}}
        @if($auth && $roleLabel)
            <span class="badge {{ $roleBadgeClass }} ms-2">{{ $roleLabel }}</span>
        @endif

        <div class="ms-auto d-flex align-items-center gap-2 flex-wrap">

            {{-- NAV mygtukai pagal rolę --}}
            @if($auth)
                @if($role === 'client')
                    <a class="{{ $navBtnClass('client.conferences') }}" href="{{ route('client.conferences.index') }}">
                        {{ __('app.nav.client') }}
                    </a>
                @endif

                @if($role === 'employee')
                    <a class="{{ $navBtnClass('employee.conferences') }}" href="{{ route('employee.conferences.index') }}">
                        {{ __('app.nav.employee') }}
                    </a>
                @endif

                @if($role === 'admin')
                    <a class="{{ $navBtnClass('admin') }}" href="{{ route('admin.index') }}">
                        {{ __('app.nav.admin') }}
                    </a>

                    <a class="{{ $navBtnClass('client.conferences') }}" href="{{ route('client.conferences.index') }}">
                        {{ __('app.nav.client') }}
                    </a>

                    <a class="{{ $navBtnClass('employee.conferences') }}" href="{{ route('employee.conferences.index') }}">
                        {{ __('app.nav.employee') }}
                    </a>
                @endif
            @endif

            {{-- Dešinė pusė: user + logout / login/register --}}
            <div class="ms-2 d-flex align-items-center gap-2">
                @if($auth)
                    <span class="text-muted small d-none d-md-inline">
                        {{ $auth['name'] ?? $auth['email'] ?? 'Vartotojas' }}
                    </span>

                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button class="btn btn-outline-secondary" type="submit">
                            {{ __('app.nav.logout') }}
                        </button>
                    </form>
                @else
                    <a class="{{ $isActive('login') ? 'btn btn-primary' : 'btn btn-outline-primary' }}" href="{{ route('login') }}">
                        {{ __('app.auth.login_button') ?? 'Prisijungti' }}
                    </a>

                    <a class="{{ $isActive('register') ? 'btn btn-primary' : 'btn btn-outline-primary' }}" href="{{ route('register') }}">
                        {{ __('app.auth.register_link') ?? 'Registracija' }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</nav>

<main class="container py-4">
    {{-- Flash --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Validation errors --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</main>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>