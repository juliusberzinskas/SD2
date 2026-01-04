@extends('layouts.app')

@section('content')
<h1 class="mb-3">{{ __('app.user.edit') }}</h1>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Vardas ir pavardė</label>
                <input type="text"
                       name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $user->name) }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('app.user.email') }}</label>
                <input type="email"
                       name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $user->email) }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Rolė</label>
                <select name="role_id" class="form-select @error('role_id') is-invalid @enderror">
                    @foreach($roles as $r)
                        <option value="{{ $r->id }}"
                            @selected(old('role_id', $currentRole) == $r->id)>
                            {{ strtoupper($r->name) }}
                        </option>
                    @endforeach
                </select>
                @error('role_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-primary" type="submit">
                    {{ __('app.conference.update') }}
                </button>

                <a class="btn btn-outline-secondary" href="{{ route('admin.users.index') }}">
                    {{ __('app.user.users') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection