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
        $kategori = Kategori::all(); // Ambil semua kategori
        $supplier = Supplier::all(); // Ambil semua supplier
        return view('barang.create', compact('kategori', 'supplier'));
    }
        public function store(Request $request)
        {
            $request->validate([
                'nama_barang' => 'required|max:255',
                'kategori_id' => 'required|exists:kategori,id',
                'harga' => 'required|numeric',
                'stok' => 'required|integer|min:0',
            ]);

            Barang::create($request->all());
            return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan!');
        }

        public function edit(Barang $barang)
        {
            $kategori = Kategori::all();
            return view('barang.edit', compact('barang', 'kategori'));
        }

        public function update(Request $request, Barang $barang)
        {
            $request->validate([
                'nama_barang' => 'required|max:255',
                'kategori_id' => 'required|exists:kategori,id',
                'harga' => 'required|numeric',
                'stok' => 'required|integer|min:0',
            ]);

            $barang->update($request->all());
            return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui!');
        }

        public function destroy(Barang $barang)
        {
            $barang->delete();
            return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus!');
        }

    public function show($id)
    {
        // Mencari supplier berdasarkan ID
        $supplier = Supplier::findOrFail($id);

        // Mengirim data supplier ke view
        return view('supplier.show', compact('supplier'));
    }

    }
