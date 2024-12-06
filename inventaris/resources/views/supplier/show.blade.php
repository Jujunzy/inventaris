@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detail Supplier</h1>

        <div class="card">
            <div class="card-header">
                <h4>{{ $supplier->nama_supplier }}</h4>
            </div>
            <div class="card-body">
                <p><strong>Nama:</strong> {{ $supplier->nama_supplier }}</p>
                <p><strong>Alamat:</strong> {{ $supplier->alamat }}</p>
                <p><strong>Kontak:</strong> {{ $supplier->kontak }}</p>

                <a href="{{ route('supplier.index') }}" class="btn btn-secondary">Kembali ke Daftar Supplier</a>
                <a href="{{ route('supplier.edit', $supplier->id) }}" class="btn btn-primary">Edit Supplier</a>
            </div>
        </div>
    </div>
@endsection
