@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Supplier</h1>

    <table class="table table-bordered">
        <tr>
            <th>Nama</th>
            <td>{{ $supplier->nama }}</td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td>{{ $supplier->alamat }}</td>
        </tr>
        <tr>
            <th>Telepon</th>
            <td>{{ $supplier->telepon }}</td>
        </tr>
    </table>

    <a href="{{ route('supplier.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
