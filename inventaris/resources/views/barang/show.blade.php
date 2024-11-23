@extends('layouts.app')

@section('title', 'Detail Barang')

@section('content')
<div class="container">
    <h1 class="mb-4">Detail Barang</h1>
    <div class="card">
        <div class="card-header">
            Informasi Barang
        </div>
        <div class="card-body">
            <p><strong>Nama Barang:</strong> {{ $barang->nama_barang }}</p>
            <p><strong>Kategori:</strong> {{ $barang->kategori->nama_kategori }}</p>
            <p><strong>Harga:</strong> Rp {{ number_format($barang->harga, 0, ',', '.') }}</p>
            <p><strong>Stok:</strong> {{ $barang->stok }}</p>
            <p><strong>Supplier:</strong> {{ $barang->supplier->nama_supplier }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('barang.index') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>
</div>
@endsection
