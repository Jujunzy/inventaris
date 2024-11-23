@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Kategori</h1>
    <div class="mb-3">
        <label for="nama_kategori" class="form-label">Nama Kategori</label>
        <input type="text" class="form-control" value="{{ $kategori->nama_kategori }}" readonly>
    </div>
    <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
