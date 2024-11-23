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
            'harga' => 'required|numeric',
            'tanggal_penjualan' => 'required|date',
        ]);

        $barang = Barang::find($request->barang_id);

        if ($barang->stok < $request->jumlah) {
            return back()->withErrors(['stok' => 'Stok barang tidak mencukupi!'])->withInput();
        }

        Penjualan::create($request->all());

        // Kurangi stok barang
        $barang->stok -= $request->jumlah;
        $barang->save();

        return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil dicatat!');
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
