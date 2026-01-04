@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h1 class="h4 mb-1">Sveiki, {{ $auth['name'] ?? 'Vartotojau' }}!</h1>
                <p class="text-muted mb-4">
                    Pasirinkite posistemį pagal savo rolę.
                </p>

                <div class="d-flex gap-2 flex-wrap">
                    @if($role === 'client')
                        <a class="btn btn-primary" href="{{ route('client.conferences.index') }}">
                            Eiti į Kliento posistemį
                        </a>
                    @endif

                    @if($role === 'employee')
                        <a class="btn btn-secondary" href="{{ route('employee.conferences.index') }}">
                            Eiti į Darbuotojo posistemį
                        </a>
                    @endif

                    @if($role === 'admin')
                        <a class="btn btn-danger" href="{{ route('admin.index') }}">
                            Eiti į Administratoriaus posistemį
                        </a>

                        <a class="btn btn-outline-primary" href="{{ route('client.conferences.index') }}">
                            Klientas (admin)
                        </a>

                        <a class="btn btn-outline-secondary" href="{{ route('employee.conferences.index') }}">
                            Darbuotojas (admin)
                        </a>
                    @endif
                </div>

                <hr class="my-4">

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-secondary" type="submit">
                        Atsijungti
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection