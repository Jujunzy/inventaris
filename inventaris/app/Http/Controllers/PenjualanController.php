<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Barang;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualan = Penjualan::with('barang')->get();
        return view('penjualan.index', compact('penjualan'));
    }

    public function create()
    {
        $barang = Barang::all();
        return view('penjualan.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'jumlah' => 'required|integer|min:1',
            'total_harga' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
        ]);

        // Simpan data ke database
        Penjualan::create([
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'total_harga' => $request->total_harga,
            'tanggal' => $request->tanggal,
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('penjualan.index')->with('success', 'Data penjualan berhasil disimpan.');
    }

    public function destroy(Penjualan $penjualan)
    {
        // Kembalikan stok barang
        $barang = Barang::find($penjualan->barang_id);
        $barang->stok += $penjualan->jumlah;
        $barang->save();

        $penjualan->delete();
        return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil dihapus!');
    }

    public function show($id)
    {
        // Mencari supplier berdasarkan ID
        $supplier = Supplier::findOrFail($id);

        // Mengirim data supplier ke view
        return view('supplier.show', compact('supplier'));
    }

}
