<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Barang;
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
            'harga' => 'required|numeric|min:0',
            'tanggal_penjualan' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    if ($value < date('Y-m-d')) {
                        $fail('Tanggal penjualan tidak boleh kurang dari hari ini.');
                    }
                },
            ],
        ]);

        // Simpan data ke database
        Penjualan::create([
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'harga' => $request->harga,
            'tanggal_penjualan' => $request->tanggal_penjualan,
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
}
