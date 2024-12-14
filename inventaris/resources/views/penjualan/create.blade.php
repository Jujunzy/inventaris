@extends('layouts.app')

@section('title', 'Tambah Penjualan')

@section('content')
    <div class="container">
        <h1 class="mb-4">Tambah Penjualan</h1>
        <div class="card">
            <div class="card-header">
                Form Tambah Penjualan
            </div>
            <div class="card-body">
                <form action="{{ route('penjualan.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="barang_id" class="form-label">Barang</label>
                        <select name="barang_id" id="barang_id"
                            class="form-select @error('barang_id') is-invalid @enderror">
                            <option value="">-- Pilih Barang --</option>
                            @foreach ($barang as $item)
                                <option value="{{ $item->id }}" {{ old('barang_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_barang }}
                                </option>
                            @endforeach
                        </select>
                        @error('barang_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" name="jumlah" id="jumlah"
                            class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah') }}">
                        @error('jumlah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="harga" class="form-label">Total Harga</label>
                        <input type="number" name="harga" id="harga"
                            class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga') }}">
                        @error('harga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_penjualan" class="form-label">Tanggal Penjualan</label>
                        <input type="date" name="tanggal_penjualan" id="tanggal_penjualan"
                            class="form-control @error('tanggal_penjualan') is-invalid @enderror"
                            value="{{ old('tanggal_penjualan') }}" min="{{ date('Y-m-d') }}">
                        @error('tanggal_penjualan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
