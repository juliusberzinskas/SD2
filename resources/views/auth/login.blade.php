@extends('layouts.app')

@section('content')
<h1 class="mb-3">Prisijungimas</h1>

<div class="card mb-3">
    <div class="card-body">
        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">El. paštas</label>
                <input type="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}">
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Slaptažodis</label>
                <input type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror">
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button class="btn btn-primary" type="submit">Prisijungti</button>
            <a class="btn btn-link" href="{{ route('register') }}">Registracija</a>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <p class="mb-2 text-muted">Greitas prisijungimas (be slaptažodžio):</p>

        <form class="d-inline" method="POST" action="{{ route('login.as_admin') }}">
            @csrf
            <button class="btn btn-outline-danger" type="submit">Prisijungti kaip administratorius</button>
        </form>

        <form class="d-inline" method="POST" action="{{ route('login.as_employee') }}">
            @csrf
            <button class="btn btn-outline-secondary" type="submit">Prisijungti kaip darbuotojas</button>
        </form>

        <div class="mt-3 text-muted">
            Admin: admin@example.com / admin123<br>
            Employee: employee@example.com / employee123
        </div>
    </div>
</div>
@endsection