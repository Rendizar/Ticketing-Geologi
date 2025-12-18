@extends('layouts.admin')

@section('title', 'Kelola Event')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 mb-2" style="font-size: 2.5rem; font-weight: 700;">Kelola Event</h1>
    <ol class="breadcrumb mb-4" style="font-size: 1rem;">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Event</li>
    </ol>

    @if(session('success'))
    <div class="alert alert-success" style="font-size: 1rem;">
        {{ session('success') }}
    </div>
    @endif

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center" style="font-size: 1.1rem; font-weight: 600;">
            <div>
                <i class="fas fa-calendar-alt me-1"></i>
                Daftar Event
            </div>
            <a href="{{ route('admin.events.create') }}" class="btn btn-success" style="font-size: 1rem;">
                <i class="fas fa-plus me-1"></i> Tambah Event
            </a>
        </div>
        <div class="card-body">
            <table id="eventsTable" class="table table-striped" style="font-size: 1rem;">
                <thead>
                    <tr style="font-weight: 600;">
                        <th style="vertical-align: middle;">Gambar</th>
                        <th style="vertical-align: middle;">Judul</th>
                        <th style="vertical-align: middle;">Tanggal</th>
                        <th style="vertical-align: middle;">Waktu</th>
                        <th style="vertical-align: middle;">Harga</th>
                        <th style="vertical-align: middle;">Kapasitas</th>
                        <th style="vertical-align: middle;">Status</th>
                        <th style="vertical-align: middle;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $event)
                    <tr>
                        <td style="vertical-align: middle;">
                            <img src="{{ asset('storage/'.$event->image) }}" alt="{{ $event->title }}" 
                                style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                        </td>
                        <td style="font-weight: 500; vertical-align: middle;">{{ $event->title }}</td>
                        <td style="vertical-align: middle;">{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</td>
                        <td style="vertical-align: middle;">{{ \Carbon\Carbon::parse($event->event_time)->format('H:i') }}</td>
                        <td style="vertical-align: middle;">Rp {{ number_format($event->price, 0, ',', '.') }}</td>
                        <td style="vertical-align: middle;">{{ $event->capacity }}</td>
                        <td style="vertical-align: middle;">
                            <span class="badge {{ $event->is_active ? 'bg-success' : 'bg-danger' }}" style="font-size: 0.9rem; padding: 0.5rem 0.75rem;">
                                {{ $event->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td style="vertical-align: middle;">
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.events.edit', $event->id) }}" 
                                   class="btn btn-warning" style="font-size: 0.95rem;">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.events.destroy', $event->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="font-size: 0.95rem;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-3">
                {{ $events->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#eventsTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            }
        });
    });
</script>
@endsection