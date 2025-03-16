<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Catalog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class CatalogController extends Controller
{
    public function index()
    {
        return view('dashboard.catalog.index');
    }

    public function data_table(Request $request)
    {
        $catalogs = Catalog::orderBy('created_at', 'asc');

        return DataTables::of($catalogs)
            ->addColumn('foto', function ($row) {
                $url = asset('storage/catalog/' . $row->foto);
                return '<img src="' . $url . '" width="100" height="100" alt="' . $row->name . '">';
            })
            ->addColumn('action', function($row) {
                $actions = '';
                $actions .= '<a href="' . route('dashboard.catalog.show', $row->slug) . '" class="btn btn-sm btn-secondary me-2 "><i class="bx bxs-show"></i></a>';
                $actions .= '<a href="' . route('dashboard.catalog.edit', $row->slug) . '" class="btn btn-sm btn-primary me-2 "><i class="bx bxs-edit"></i></a>';
                $actions .= '<button data-id="'.$row['slug'].'" class="btn btn-sm btn-danger btn-delete me-2"><i class="bx bxs-trash"></i></button>';
                return $actions;

            })
            ->rawColumns(['action','foto'])
            ->addIndexColumn()
            ->make(true);
    }
    public function create()
    {
        return view('dashboard.catalog.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'foto' => 'required',
            'desc' => 'required|string',
        ]);

        $file_name = null;

        // Handle image file upload
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $upload_path = public_path('storage/catalog/');
            $file_name = 'Catalog_' . Str::slug(Str::random(6)) . '_' . date('YmdHis') . '.' . $file->getClientOriginalExtension();

            $file->move($upload_path, $file_name);
        }

        $catalog = Catalog::create([
            'name' => $request->name,
            'foto' => $file_name,
            'desc' => $request->desc,
        ]);

        return redirect()->route('dashboard.catalog.index')->with('success','Berhasil Menambahkan Data');
    }

    public function show($slug)
    {
        $catalog = Catalog::where('slug', $slug)->firstOrFail();
        return view('dashboard.catalog.show', compact('catalog'));
    }

    public function edit($slug)
    {
        $catalog = Catalog::where('slug', $slug)->firstOrFail();

        return view('dashboard.catalog.edit', compact('catalog'));
    }

    public function update(Request $request, $slug)
    {
        $request->validate([
            'name' => 'required|string',
            'foto' => 'nullable',
            'desc' => 'required|string',
        ]);

        $catalog = Catalog::where('slug', $slug)->firstOrFail();

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $upload_path = public_path('storage/catalog/');
            $file_name = 'Catalog_' . Str::slug(Str::random(6)) . '_' . date('YmdHis') . '.' . $file->getClientOriginalExtension();

            $file->move($upload_path, $file_name);
            $catalog->foto = $file_name;
        }

        $catalog->name = $request->name;
        $catalog->desc = $request->desc;
        $catalog->save();

        return redirect()->route('dashboard.catalog.index')->with('success','Berhasil Mengubah Data');
    }

    public function destroy()
    {

    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('gambar_upload')) {
            $file = $request->file('gambar_upload');
            $ext = $file->getClientOriginalExtension();

            $upload_path = public_path('storage/catalog/');
            $filename = 'Catalog_' . Str::slug(Str::random(6)) . '_' . date('YmdHis') . '.' . $ext;

            $file->move($upload_path, $filename);

            // Berikan URL file yang dapat digunakan
            $fileUrl = url('storage/catalog/' . $filename);

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
