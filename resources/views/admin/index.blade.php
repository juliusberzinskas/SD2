@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h1 class="mb-3">{{ __('app.admin.title') ?? 'Administratoriaus posistemis' }}</h1>

        <div class="d-flex gap-2 flex-wrap">
            <a class="btn btn-primary" href="{{ route('admin.users.index') }}">
                {{ __('app.admin.manage_users') ?? 'Naudotojų valdymas' }}
            </a>

            <a class="btn btn-outline-primary" href="{{ route('admin.conferences.index') }}">
                {{ __('app.admin.manage_conferences') ?? 'Konferencijų valdymas' }}
            </a>
        </div>
    </div>
</div>
@endsection
