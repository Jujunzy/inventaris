@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pembelian</h1>
    <a href="{{ route('pembelian.create') }}" class="btn btn-primary mb-3">Tambah Pembelian</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Id</th>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
                <th>Supplier</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pembelian as $pembelian)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $pembelian->barang->nama }}</td>
                    <td>{{ $pembelian->jumlah }}</td>
                    <td>{{ number_format($pembelian->total_harga, 0, ',', '.') }}</td>
                    <td>{{ $pembelian->supplier->nama }}</td>
                    <td>
                        <a href="{{ route('pembelian.show', $pembelian->id) }}" class="btn btn-info btn-sm">Lihat</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
