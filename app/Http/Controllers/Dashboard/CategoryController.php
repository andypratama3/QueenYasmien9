<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        $limit = 15;
        $category = Category::select(['id','name'])->orderBy('name','asc')->paginate($limit);
        $category_count = Category::count();
        $no = $limit * ($category->currentPage() - 1);

        return view('dashboard.category.index', compact('category', 'category_count', 'no'));
    }

    public function create()
    {
        return view('dashboard.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $category = Category::create([
            'name' => $request->name,
        ]);

        return redirect()->route('dashboard.category.index')->with('success','Data berhasil disimpan');
    }

    public function edit(Category $category)
    {
        return view('dashboard.category.edit', compact('category'));
    }

    public function update(Request $request,Category $category)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('dashboard.category.index')->with('success','Data berhasil dirubah');
    }


/*************  ✨ Codeium Command ⭐  *************/
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
/******  ceed4986-d3cc-4004-843e-ceac3504be21  *******/    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('dashboard.category.index')->with('success','Berhasil Menghapus Data');
    }
}
