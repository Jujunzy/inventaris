@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pembelian</h1>
    <a href="{{ route('pembelian.create') }}" class="btn btn-primary mb-3">Tambah Pembelian</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
                <th>Supplier</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pembelian as $item) <!-- Jangan overwrite variabel $pembelian -->
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->barang->nama_barang ?? 'Barang tidak ditemukan' }}</td> <!-- Hindari error jika barang null -->
                    <td>{{ $item->jumlah }}</td>
                    <td>{{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td>{{ $item->supplier->nama_supplier ?? 'Supplier tidak ditemukan' }}</td> <!-- Hindari error jika supplier null -->
                    <td>
                        <a href="{{ route('pembelian.show', $item->id) }}" class="btn btn-info btn-sm">Lihat</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
