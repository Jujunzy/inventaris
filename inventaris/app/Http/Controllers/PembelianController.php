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
        $pembelian = Pembelian::with('barang', 'supplier')->get();
        return view('pembelian.index', compact('pembelian'));
    }

    public function create()
    {
        $barang = Barang::all();
        $supplier = Supplier::all();
        return view('pembelian.create', compact('barang', 'supplier'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required',
            'supplier_id' => 'required',
            'jumlah' => 'required|integer|min:1',
            'harga' => 'required|numeric',
            'tanggal_pembelian' => 'required|date',
        ]);

        Pembelian::create($request->all());

        // Update stok barang
        $barang = Barang::find($request->barang_id);
        $barang->stok += $request->jumlah;
        $barang->save();

        return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil dicatat!');
    }

    public function destroy(Pembelian $pembelian)
    {
        // Update stok barang
        $barang = Barang::find($pembelian->barang_id);
        $barang->stok -= $pembelian->jumlah;
        $barang->save();

        $pembelian->delete();
        return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil dihapus!');
    }
}
