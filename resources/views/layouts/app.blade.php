<!doctype html>
<html lang="lt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('app.app_title') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
    <div class="container">
        <a class="navbar-brand" href="{{ route('login') }}">{{ __('app.app_title') }}</a>

        <div class="ms-auto d-flex align-items-center gap-3">

            @php($auth = session('auth_user'))

            @if($auth)
                <div class="d-flex gap-2">
                    <a class="btn btn-outline-primary" href="{{ route('client.conferences.index') }}">
                        {{ __('app.nav.client') }}
                    </a>
                    <a class="btn btn-outline-primary" href="{{ route('employee.conferences.index') }}">
                        {{ __('app.nav.employee') }}
                    </a>
                    <a class="btn btn-outline-primary" href="{{ route('admin.index') }}">
                        {{ __('app.nav.admin') }}
                    </a>
                </div>
            @endif

        </div>
    </div>
</nav>

<main class="container py-4">
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @yield('content')
</main>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>