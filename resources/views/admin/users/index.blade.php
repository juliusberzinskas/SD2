@extends('layouts.app')

@section('content')
<h1 class="mb-3">{{ __('app.user.users') }}</h1>

<table class="table table-striped align-middle">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ __('app.user.first_name') ?? 'Vardas' }}</th>
            <th>{{ __('app.user.email') }}</th>
            <th>Rolė</th>
            <th class="text-end">{{ __('app.conference.actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse($users as $u)
            <tr>
                <td>{{ $u->id }}</td>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>
                    @php($roleName = $u->roles->pluck('name')->first())
                    @if($roleName)
                        <span class="badge bg-light text-dark text-uppercase">{{ $roleName }}</span>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
                <td class="text-end">
                    <a class="btn btn-sm btn-outline-secondary"
                       href="{{ route('admin.users.edit', $u->id) }}">
                        {{ __('app.user.edit') }}
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-muted">0</td>
            </tr>
        @endforelse
    </tbody>
</table>

<a class="btn btn-outline-primary" href="{{ route('admin.index') }}">
    {{ __('app.nav.admin') }}
</a>
@endsection