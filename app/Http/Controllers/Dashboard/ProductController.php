<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index()
    {
        return view('dashboard.product.index');
    }

    public function data_table(Request $request)
    {
        $products = Product::with('category')->orderBy('name', 'asc');

        return DataTables::of($products)
            ->addColumn('name', function ($row) {
                return Str::limit($row->name, 25);
            })
            ->addColumn('price', function ($row) {
                return 'Rp. ' . number_format($row->price, 0, ',', '.');
            })
            ->addColumn('category', function ($row) {
                return $row->category->name ?? '-';
            })
            ->addColumn('sell_count', function($row) {
                return $row->sell_count ?? '0';
            })
            ->addColumn('action', function($row) {
                $actions = '';
                $actions .= '<a href="' . route('dashboard.product.show', $row->slug) . '" class="btn btn-sm btn-secondary me-2 "><i class="bx bxs-show"></i></a>';
                $actions .= '<a href="' . route('dashboard.product.edit', $row->slug) . '" class="btn btn-sm btn-primary me-2 "><i class="bx bxs-edit"></i></a>';
                $actions .= '<button data-id="'.$row['slug'].'" class="btn btn-sm btn-danger btn-delete me-2"><i class="bx bxs-trash"></i></button>';
                return $actions;

            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function create()
    {
        $categorys = Category::orderBy('name', 'asc')->get();
        return view('dashboard.product.create', compact('categorys'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'foto' => 'required',
            'stock' => 'required|min:1',
        ]);

        $file_name = null;




        // Handle image file upload
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $upload_path = public_path('storage/product/');
            $file_name = 'Product_' . Str::slug(Str::random(6)) . '_' . date('YmdHis') . '.' . $file->getClientOriginalExtension();

            $file->move($upload_path, $file_name);
        }

        $products = Product::create([
            'name' => $request->name,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'desc' => $request->desc,
            'price' => str_replace('.', '', $request->price),
            'foto' => $file_name,
        ]);

        return redirect()->route('dashboard.product.index')->with('success', 'Berhasil Menambahkan Produk');

    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('dashboard.product.show', compact('product'));
    }


    public function edit($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $categorys = Category::orderBy('name', 'asc')->get();

        return view('dashboard.product.edit', compact('product','categorys'));
    }

    public function update(Request $request, $slug)
    {
        $request->validate([
            'name' => 'required',
            'stock' => 'required|min:1',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product = Product::where('slug', $slug)->firstOrFail();
        $file_name = $product->foto; // Simpan gambar lama jika tidak diubah

        // Handle image file upload
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $upload_path = public_path('storage/product/');
            $file_name = 'Product_' . Str::slug(Str::random(6)) . '_' . date('YmdHis') . '.' . $file->getClientOriginalExtension();

            // Hapus gambar lama jika ada
            if ($product->foto && file_exists($upload_path . $product->foto)) {
                unlink($upload_path . $product->foto);
            }

            $file->move($upload_path, $file_name);
        }

        // Update produk
        $product->update([
            'name' => $request->name,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'desc' => $request->desc,
            'price' => str_replace('.', '', $request->price),
            'foto' => $file_name,
        ]);

        return redirect()->route('dashboard.product.index')->with('success', 'Produk berhasil diperbarui');
    }



    public function destroy($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $actions = $product->delete();

        if($actions) {
            return response()->json(['status' => 'success','message' => 'Berhasil Menghapus Data']);
        } else {
            return response()->json(['status' => 'error','message' => 'Gagal Menghapus Data']);

        }
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('gambar_upload')) {
            $file = $request->file('gambar_upload');
            $ext = $file->getClientOriginalExtension();

            $upload_path = public_path('storage/product/');
            $filename = 'product_' . Str::slug(Str::random(6)) . '_' . date('YmdHis') . '.' . $ext;

            $file->move($upload_path, $filename);

            // Berikan URL file yang dapat digunakan
            $fileUrl = url('storage/product/' . $filename);

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil Mengupload Gambar',
                'url' => $fileUrl,
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Gagal mengunggah gambar',
        ], 400);
    }

}
