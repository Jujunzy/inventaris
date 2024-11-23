@extends('layouts.app')

@section('title', 'Daftar Barang')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Barang</h1>
    <a href="{{ route('barang.create') }}" class="btn btn-primary mb-3">Tambah Barang</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Supplier</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barang as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->kategori->nama_kategori }}</td>
                    <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td>{{ $item->stok }}</td>
                    <td>{{ $item->nama_supplier ? $item->supplier->nama_supplier : '' }}</td>
                    <td>
                        <a href="{{ route('barang.show', $item->id) }}" class="btn btn-info btn-sm">Lihat</a>
                        <a href="{{ route('barang.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('barang.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus barang ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data barang.</td>
                </tr>
        </tbody>
    </table>
</div>
@endsection
