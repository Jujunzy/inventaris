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
        $validatedData = $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'jumlah' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
            'tanggal_penjualan' => 'required|date|after_or_equal:today',
        ], [
            'barang_id.required' => 'Barang harus dipilih.',
            'barang_id.exists' => 'Barang yang dipilih tidak valid.',
            'jumlah.required' => 'Jumlah wajib diisi.',
            'jumlah.integer' => 'Jumlah harus berupa angka.',
            'jumlah.min' => 'Jumlah minimal adalah 1.',
            'harga.required' => 'Total harga wajib diisi.',
            'harga.numeric' => 'Total harga harus berupa angka.',
            'harga.min' => 'Total harga tidak boleh kurang dari 0.',
            'tanggal_penjualan.required' => 'Tanggal penjualan wajib diisi.',
            'tanggal_penjualan.date' => 'Tanggal penjualan harus berupa tanggal yang valid.',
            'tanggal_penjualan.after_or_equal' => 'Tanggal penjualan tidak boleh kurang dari hari ini.',
        ]);

        // Simpan data ke database
        Penjualan::create($validatedData);

        // Redirect dengan pesan sukses
        return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil ditambahkan.');
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
