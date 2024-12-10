<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';
    protected $fillable = ['nama_barang', 'supplier_id','kategori_id', 'harga', 'stok'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function pembelian()
    {
        return $this->hasMany(Pembelian::class, 'barang_id');
    }

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'barang_id');
    }

    // Model Barang.php
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
