@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Daftar Bukti Pembayaran</h1>
    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr>
                    <th class="px-4 py-2 border-b">#</th>
                    <th class="px-4 py-2 border-b">User</th>
                    <th class="px-4 py-2 border-b">Bank</th>
                    <th class="px-4 py-2 border-b">Nomor Rekening</th>
                    <th class="px-4 py-2 border-b">Foto</th>
                    <th class="px-4 py-2 border-b">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dibayars as $dibayar)
                <tr>
                    <td class="px-4 py-2 border-b">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 border-b">{{ $dibayar->user->name ?? '-' }}</td>
                    <td class="px-4 py-2 border-b">{{ $dibayar->rekening->bank_name ?? '-' }}</td>
                    <td class="px-4 py-2 border-b">{{ $dibayar->rekening->number ?? '-' }}</td>
                    <td class="px-4 py-2 border-b">
                        @if($dibayar->foto)
                            <img src="{{ asset('storage/' . $dibayar->foto) }}" alt="Bukti" class="h-12">
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-4 py-2 border-b">
                        <a href="{{ route('dibayars.show', $dibayar->id) }}" class="text-indigo-600 hover:underline">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4">Belum ada data.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
