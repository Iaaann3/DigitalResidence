@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h3 class="mb-4">Detail Kritik & Saran</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <p><strong>User:</strong> {{ $kritik->user->name ?? '-' }}</p>
            <p><strong>Tanggal:</strong> {{ $kritik->created_at->format('d-m-Y H:i') }}</p>
            <hr>
            <p><strong>Isi:</strong></p>
            <p>{{ $kritik->isi }}</p>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.saran.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection
