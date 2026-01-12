@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 max-w-xl">
    <h1 class="text-2xl font-bold mb-6">Detail Bukti Pembayaran</h1>
    <div class="bg-white shadow rounded-lg p-6">
        <div class="mb-4">
            <span class="font-semibold">User:</span>
            {{ $dibayar->user->name ?? '-' }}
        </div>
        <div class="mb-4">
            <span class="font-semibold">Bank:</span>
            {{ $dibayar->rekening->bank_name ?? '-' }}
        </div>
        <div class="mb-4">
            <span class="font-semibold">Nomor Rekening:</span>
            {{ $dibayar->rekening->number ?? '-' }}
        </div>
        <div class="mb-4">
            <span class="font-semibold">Foto Bukti:</span><br>
            @if($dibayar->foto)
                <img src="{{ asset('storage/' . $dibayar->foto) }}" alt="Bukti" class="h-40 mt-2">
            @else
                -
            @endif
        </div>
        <a href="{{ route('dibayars.index') }}" class="text-gray-600 hover:underline">Kembali</a>
    </div>
</div>
@endsection
