<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Supplier;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::with('kategori', 'supplier')->get();
        return view('barang.index', compact('barang'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        $supplier = Supplier::all();
        return view('barang.create', compact('kategori', 'supplier'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'nama_barang' => 'required|max:255',
                'kategori_id' => 'required|exists:kategori,id',
                'supplier_id' => 'required|exists:supplier,id',
                'harga' => 'required|numeric|min:0', // Tambahkan aturan min:0
                'stok' => 'required|integer|min:0',
            ],
            $this->validationMessages(),
            $this->attributeNames()
        );


        Barang::create($validated);
        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    public function edit(Barang $barang)
    {
        $kategoris = Kategori::all();
        return view('barang.edit', compact('barang', 'kategoris'));
    }

    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate(
            [
                'nama_barang' => 'required|max:255',
                'kategori_id' => 'required|exists:kategori,id',
                'supplier_id' => 'required|exists:supplier,id',
                'harga' => 'required|numeric',
                'stok' => 'required|integer|min:0',
            ],
            $this->validationMessages(),
            $this->attributeNames()
        );

        $barang->update($validated);
        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui!');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus!');
    }

    public function show($id)
    {
        $barang = Barang::with('supplier')->findOrFail($id);
        return view('barang.show', compact('barang'));
    }

    private function validationMessages()
    {
        return [
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'nama_barang.max' => 'Nama barang tidak boleh lebih dari :max karakter.',
            'kategori_id.required' => 'Kategori wajib dipilih.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
            'supplier_id.required' => 'Supplier wajib dipilih.',
            'supplier_id.exists' => 'Supplier yang dipilih tidak valid.',
            'harga.required' => 'Harga barang wajib diisi.',
            'harga.numeric' => 'Harga barang harus berupa angka.',
            'harga.min' => 'Harga barang tidak boleh bernilai negatif.', // Pesan untuk aturan min
            'stok.required' => 'Stok barang wajib diisi.',
            'stok.integer' => 'Stok barang harus berupa angka bulat.',
            'stok.min' => 'Stok barang tidak boleh kurang dari :min.',
        ];
    }


    private function attributeNames()
    {
        return [
            'nama_barang' => 'Nama Barang',
            'kategori_id' => 'Kategori',
            'supplier_id' => 'Supplier',
            'harga' => 'Harga',
            'stok' => 'Stok',
        ];
    }
}
