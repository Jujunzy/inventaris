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
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kontak' => 'required|string|max:15|unique:supplier,kontak',
        ]);

        // Simpan data supplier
        Supplier::create([
            'nama_supplier' => $request->nama_supplier,
            'alamat' => $request->alamat,
            'kontak' => $request->kontak,
        ]);

        // Redirect ke index dengan pesan sukses
        return redirect()->route('supplier.index')->with('success', 'Data supplier berhasil ditambahkan.');
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
            'kontak' => 'nullable|max:15|unique:supplier,kontak,' . $supplier->id,
        ]);

        $supplier->update($request->all());
        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil diperbarui!');
    }


    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil dihapus!');
    }

    public function show($id)
    {
        $supplier = Supplier::findOrFail($id);  // Ambil data supplier berdasarkan ID
        return view('supplier.show', compact('supplier'));
    }

}
