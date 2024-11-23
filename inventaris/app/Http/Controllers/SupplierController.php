<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $supplier = Supplier::all();
        return view('supplier.index', compact('supplier'));
    }

    public function create()
    {
        return view('supplier.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_supplier' => 'required|max:255',
            'alamat' => 'required',
            'kontak' => 'required|digits_between:10,13', // Validasi telepon
        ]);

        // Simpan data supplier
        Supplier::create($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil ditambahkan!');
    }

    public function edit(Supplier $supplier)
    {
        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'nama_supplier' => 'required|max:255',
            'alamat' => 'required',
            'kontak' => 'nullable|max:255',
        ]);

        $supplier->update($request->all());
        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil diperbarui!');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil dihapus!');
    }

    public function show(Supplier $supplier)
    {
        return view('supplier.show', compact('supplier'));
    }
}