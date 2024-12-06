<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Barang;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    public function index()
    {
        // Mengambil semua data pembelian dengan relasi barang dan supplier
        $pembelian = Pembelian::with('barang', 'supplier')->get();
        return view('pembelian.index', compact('pembelian'));
    }

    public function create()
    {
        // Mengambil semua data barang dan supplier untuk dropdown
        $barang = Barang::all();
        $supplier = Supplier::all();
        return view('pembelian.create', compact('barang', 'supplier'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'supplier_id' => 'required|exists:supplier,id',
            'jumlah' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
            'tanggal_pembelian' => 'required|date',
        ]);

        // Membuat data pembelian
        $pembelian = Pembelian::create($request->only('barang_id', 'supplier_id', 'jumlah', 'harga', 'tanggal_pembelian'));

        // Update stok barang
        $barang = Barang::find($request->barang_id);
        if ($barang) {
            $barang->stok += $request->jumlah;
            $barang->save();
        }

        return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil dicatat!');
    }

    public function destroy(Pembelian $pembelian)
    {
        // Update stok barang
        $barang = Barang::find($pembelian->barang_id);
        if ($barang) {
            $barang->stok -= $pembelian->jumlah;
            $barang->save();
        }

        // Hapus data pembelian
        $pembelian->delete();
        return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil dihapus!');
    }
}
