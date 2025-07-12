@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manajemen Pengguna</h3>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">
                        <i class="bi bi-plus-circle"></i> Tambah Pengguna Baru
                    </a>

                    {{-- Pesan Sukses --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <form method="GET" action="{{ route('admin.users.index') }}" class="mb-3 row">
    <div class="col-md-3">
        <select name="role" class="form-select" onchange="this.form.submit()">
            <option value="">🔍 Tampilkan: Semua</option>
            <option value="Instructor" {{ request('role') == 'Instructor' ? 'selected' : '' }}>Instructor</option>
            <option value="Peserta" {{ request('role') == 'Peserta' ? 'selected' : '' }}>Peserta</option>
        </select>
    </div>
</form>

@if($roleFilter)
    <p class="text-muted">Menampilkan pengguna dengan peran: <strong>{{ $roleFilter }}</strong></p>
@endif

                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
    <tr class="text-center">
        <th>No</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Peran</th>
        <th>Aksi</th>
    </tr>
</thead>
<tbody>
    @forelse ($users as $user)
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td class="text-center">
                @php
                    $roleColor = match($user->role->name) {
                        'Peserta' => 'success',
                        'Instructor' => 'warning',
                        default => 'secondary',
                    };
                @endphp
                <span class="badge bg-{{ $roleColor }}">{{ $user->role->name }}</span>
            </td>
            <td class="text-center">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-warning me-1">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger"
                        onclick="return confirm('Yakin ingin menghapus pengguna ini?')">
                        <i class="bi bi-trash3"></i>
                    </button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="text-center text-muted">Tidak ada data pengguna.</td>
        </tr>
    @endforelse
</tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection