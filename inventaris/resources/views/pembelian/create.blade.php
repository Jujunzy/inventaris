@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Tambah Pembelian</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('pembelian.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="barang_id" class="form-label">Barang</label>
                <select name="barang_id" id="barang_id" class="form-control">
                    <option value="">Pilih Barang</option>
                    @foreach ($barang as $item)
                        <option value="{{ $item->id }}" {{ old('barang_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_barang }}
                        </option>
                    @endforeach
                </select>
                @error('barang_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah</label>
                <input type="number" name="jumlah" id="jumlah" class="form-control" value="{{ old('jumlah') }}">
                @error('jumlah')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" name="harga" id="harga" class="form-control" value="{{ old('harga') }}" min="0">
                @error('harga')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="supplier_id" class="form-label">Supplier</label>
                <select name="supplier_id" id="supplier_id" class="form-control">
                    <option value="">Pilih Supplier</option>
                    @foreach ($supplier as $item)
                        <option value="{{ $item->id }}" {{ old('supplier_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_supplier }}
                        </option>
                    @endforeach
                </select>
                @error('supplier_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tanggal_pembelian" class="form-label">Tanggal Pembelian</label>
                <input
                    type="date"
                    name="tanggal_pembelian"
                    id="tanggal_pembelian"
                    class="form-control"
                    value="{{ old('tanggal_pembelian') }}"
                    min="{{ date('Y-m-d') }}"
                >
                @error('tanggal_pembelian')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
