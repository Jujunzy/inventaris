<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        // Mengurutkan data supplier berdasarkan `created_at` terbaru
        $supplier = Supplier::orderBy('created_at', 'desc')->get();

        return view('supplier.index', compact('supplier'));
    }


    public function create()
    {
        return view('supplier.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'alamat' => 'required|string|max:500',
            'kontak' => 'required|string|max:15',
        ], [
            'nama_supplier.required' => 'Nama supplier wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'kontak.required' => 'Nomor telepon wajib diisi.',
        ]);

        // Simpan data ke database
        Supplier::create($validatedData);

        // Redirect dengan pesan sukses
        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil ditambahkan.');
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
        try {

            $supplier->delete();
            return redirect()->route('supplier.index')->with('success', 'Supplier berhasil dihapus!');
        } catch (QueryException $e) {

            return redirect()->route('supplier.index')->with('error', 'Supplier tidak bisa dihapus karena digunakan di table lain');
        }
    }

    public function show($id)
    {
        $supplier = Supplier::findOrFail($id);  // Ambil data supplier berdasarkan ID
        return view('supplier.show', compact('supplier'));
    }
}
