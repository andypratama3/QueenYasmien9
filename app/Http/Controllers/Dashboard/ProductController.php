<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductReseller;
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
                return 'Rp. ' . number_format((float) ($row->price ?? 0), 0, ',', '.');

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
            'price' => $request->price !== null ? (int) str_replace('.', '', $request->price) : 0,
            'foto' => $file_name,

        ]);

        if ($request->has('name_packet') && is_array($request->name_packet)) {
            foreach ($request->name_packet as $key => $packet_name) {

                if (!empty($packet_name)) {
                    ProductReseller::create([
                        'product_id' => $products->id,
                        'name' => $packet_name, // Pastikan name ada isinya
                        'price_reseller' => str_replace(['Rp ', '.'], '', $request->price_reseller[$key] ?? 0), // Ambil dari price_reseller
                        'jumlah' => $request->jumlah[$key] ?? 0,
                    ]);
                }
            }
        }

        return redirect()->route('dashboard.product.index')->with('success', 'Berhasil Menambahkan Produk');

    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $resellerPackages = ProductReseller::where('product_id', $product->id)->get();

        return view('dashboard.product.show', compact('product','resellerPackages'));
    }


    public function edit($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $categorys = Category::orderBy('name', 'asc')->get();

        // Check if the product is in "Paket Reseller" category
        $resellerPackages = ProductReseller::where('product_id', $product->id)->get();

        return view('dashboard.product.edit', compact('product', 'categorys', 'resellerPackages'));
    }

    public function update(Request $request, $slug)
    {
        $request->validate([
            'name' => 'required',
            'stock' => 'required|min:1',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product = Product::where('slug', $slug)->firstOrFail();
        $file_name = $product->foto; // Gunakan gambar lama jika tidak ada yang diunggah

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
            'price' => str_replace('.', '', $request->price) ?? null,
            'foto' => $file_name,
        ]);

        // **Perbarui data reseller jika produk adalah "Paket Reseller"**
        if ($request->has('name_packet') && is_array($request->name_packet)) {
            if (!empty($packet_name)) {
                ProductReseller::where('product_id', $product->id)->delete();
                foreach ($request->name_packet as $key => $packet_name) {
                    ProductReseller::create([
                        'product_id' => $product->id,
                        'name' => $packet_name,
                        'price_reseller' => str_replace(['Rp ', '.'], '', $request->price_reseller[$key] ?? 0),
                        'jumlah' => $request->jumlah[$key] ?? 0,
                    ]);
                }
            }
        }

        return redirect()->route('dashboard.product.index')->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $product->product_reseller()->delete(); // Hapus data
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
