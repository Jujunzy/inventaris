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
        // Validasi input dengan memastikan tanggal pembelian >= hari ini
        $request->validate(
            [
                'barang_id' => 'required|exists:barang,id',
                'supplier_id' => 'required|exists:supplier,id',
                'jumlah' => 'required|integer|min:1',
                'harga' => 'required|numeric|min:0',
                'tanggal_pembelian' => 'required|date|after_or_equal:today',
            ],
            [
                'barang_id.required' => 'Barang harus dipilih.',
                'barang_id.exists' => 'Barang yang dipilih tidak valid.',
                'supplier_id.required' => 'Supplier harus dipilih.',
                'supplier_id.exists' => 'Supplier yang dipilih tidak valid.',
                'jumlah.required' => 'Jumlah harus diisi.',
                'jumlah.integer' => 'Jumlah harus berupa angka.',
                'jumlah.min' => 'Jumlah minimal adalah 1.',
                'harga.required' => 'Harga harus diisi.',
                'harga.numeric' => 'Harga harus berupa angka.',
                'harga.min' => 'Harga tidak boleh negatif.',
                'tanggal_pembelian.required' => 'Tanggal pembelian harus diisi.',
                'tanggal_pembelian.date' => 'Tanggal pembelian harus berupa tanggal yang valid.',
                'tanggal_pembelian.after_or_equal' => 'Tanggal pembelian tidak boleh kurang dari hari ini.',
            ]
        );

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
