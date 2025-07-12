@extends('layouts.admin')

@section('title', 'Daftar Peserta: ' . $kursu->judul)

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-1">Peserta Kursus: <span class="text-primary">{{ $kursu->judul }}</span></h5>
            <small class="text-muted">Kelola peserta yang terdaftar pada kursus ini</small>
        </div>
        <a href="{{ route('admin.kursus.index') }}" class="btn btn-sm btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Manajemen Kursus
        </a>
    </div>

    <div class="card-body">
        {{-- Flash Message --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Form Tambah Peserta --}}
        <form action="{{ route('admin.kursus.peserta.tambah', $kursu->id) }}" method="POST" class="row g-3 align-items-end mb-4">
            @csrf
            <div class="col-md-5">
                <label for="user_id" class="form-label fw-bold">Tambah Peserta Baru</label>
                <select name="user_id" id="user_id" class="form-select" required>
                    <option value="">-- Pilih Peserta --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-person-plus me-1"></i> Tambah
                </button>
            </div>
        </form>

        {{-- Tabel Peserta --}}
        @if ($kursu->peserta->isEmpty())
            <div class="alert alert-warning">Belum ada peserta yang mendaftar kursus ini.</div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Tanggal Daftar</th>
                            <th style="width: 80px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kursu->peserta as $peserta)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $peserta->name }}</td>
                                <td>{{ $peserta->email }}</td>
                                <td>{{ optional($peserta->pivot->created_at)->format('d M Y') ?? '-' }}</td>
                                <td>
                                    <form action="{{ route('admin.kursus.peserta.hapus', [$kursu->id, $peserta->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus peserta ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
