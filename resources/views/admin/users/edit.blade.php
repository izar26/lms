@extends('layouts.admin')

@section('title', 'Edit Pengguna')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Pengguna: {{ $user->name }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Nama --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Alamat Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Peran (Role) --}}
                        <div class="mb-3">
                            <label for="role_id" class="form-label">Peran (Role)</label>
                            <select class="form-select @error('role_id') is-invalid @enderror" id="role_id" name="role_id" required>
                                <option value="" disabled>-- Pilih Peran --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection