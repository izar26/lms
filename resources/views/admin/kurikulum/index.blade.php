@extends('layouts.admin')

@section('title', 'Manajemen Kurikulum')

@section('content')
    <h1 class="mb-2">Kelola Kurikulum</h1>
    <h5 class="mb-4 text-muted">Untuk Kursus: {{ $kursus->judul }}</h5>

    @if(session('sukses'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('sukses') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    {{-- Form untuk Menambah MODUL BARU --}}
    <div class="card mb-4">
        <div class="card-header fw-bold">Tambah Modul Baru</div>
        <div class="card-body">
            <form action="{{ route('admin.modul.store', $kursus->id) }}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="text" name="judul_modul" class="form-control" placeholder="Masukkan judul modul baru..." required>
                    <button class="btn btn-primary" type="submit">Simpan Modul</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Daftar Modul dan Materinya --}}
    <h3 class="mt-5">Daftar Modul & Materi</h3>
    @forelse ($kursus->modul as $modul)
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Modul {{ $loop->iteration }}: {{ $modul->judul_modul }}</h5>
                <div>
                    {{-- Tombol Edit & Hapus Modul --}}
                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editModulModal-{{ $modul->id }}">Edit</button>
                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModulModal-{{ $modul->id }}">Hapus</button>
                </div>
            </div>
            <div class="card-body">
                {{-- Daftar Materi yang Sudah Ada --}}
                <ul class="list-group list-group-flush mb-3">
                    @forelse ($modul->materi as $materi)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $materi->judul_materi }}
                            <div>
                                {{-- === TOMBOL BARU DITAMBAHKAN DI SINI === --}}
                                <a href="{{ route('admin.materi.isi', $materi->id) }}" class="btn btn-sm btn-outline-primary">Isi Materi</a>
                                {{-- Tombol Edit & Hapus Materi --}}
                                <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editMateriModal-{{ $materi->id }}">Edit</button>
                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteMateriModal-{{ $materi->id }}">Hapus</button>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">Belum ada materi di modul ini.</li>
                    @endforelse
                </ul>

                {{-- Form untuk Menambah MATERI BARU di modul ini --}}
                <hr>
                <form action="{{ route('admin.materi.store', $modul->id) }}" method="POST" class="mt-3">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="judul_materi" class="form-control" placeholder="Tambah materi baru di modul ini..." required>
                        <button class="btn btn-secondary btn-sm" type="submit">Simpan Materi</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal Edit Modul --}}
        <div class="modal fade" id="editModulModal-{{ $modul->id }}" tabindex="-1" aria-labelledby="editModulLabel-{{ $modul->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModulLabel-{{ $modul->id }}">Edit Modul</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.modul.update', $modul->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <input type="text" name="judul_modul" class="form-control" value="{{ $modul->judul_modul }}" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        {{-- Modal Delete Modul --}}
        <div class="modal fade" id="deleteModulModal-{{ $modul->id }}" tabindex="-1" aria-labelledby="deleteModulLabel-{{ $modul->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModulLabel-{{ $modul->id }}">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus modul <strong>"{{ $modul->judul_modul }}"</strong>? <br>
                        <small class="text-danger">Semua materi di dalam modul ini juga akan terhapus.</small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('admin.modul.destroy', $modul->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Loop untuk Modal Materi --}}
        @foreach($modul->materi as $materi)
            {{-- Modal Edit Materi --}}
            <div class="modal fade" id="editMateriModal-{{ $materi->id }}" tabindex="-1" aria-labelledby="editMateriLabel-{{ $materi->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editMateriLabel-{{ $materi->id }}">Edit Materi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('admin.materi.update', $materi->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <input type="text" name="judul_materi" class="form-control" value="{{ $materi->judul_materi }}" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Modal Delete Materi --}}
            <div class="modal fade" id="deleteMateriModal-{{ $materi->id }}" tabindex="-1" aria-labelledby="deleteMateriLabel-{{ $materi->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteMateriLabel-{{ $materi->id }}">Konfirmasi Hapus</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda yakin ingin menghapus materi <strong>"{{ $materi->judul_materi }}"</strong>?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <form action="{{ route('admin.materi.destroy', $materi->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    @empty
        <div class="alert alert-warning">Belum ada modul untuk kursus ini.</div>
    @endforelse
@endsection