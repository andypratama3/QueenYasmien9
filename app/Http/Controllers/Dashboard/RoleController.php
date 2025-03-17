<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            // new Middleware('role:superadmin'),
        ];
    }

    public function index()
    {
        return view('dashboard.roles.index');
    }

    public function data_table(Request $request)
    {
        $roles = Role::where('name', '!=', 'superadmin');

        return DataTables::of($roles)
            ->addColumn('action', function ($role) {
                $actions = '';
                $actions .= '<a href="' . route('dashboard.settings.roles.edit', $role->id) . '" class="btn btn-sm btn-warning me-2 "><i class="bx bxs-edit"></i></a>';
                $actions .= '<button data-id="'.$role['id'].'" class="btn btn-sm btn-danger btn-delete me-2"><i class="bx bxs-trash"></i></button>';
                return $actions;
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);

    }

    public function create()
    {
        $permissions = Permission::orderBy('name','asc')->get();
        return view('dashboard.roles.create', compact('permissions'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'required|array|min:1',
        ]);


        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        $role->permissions()->sync($request->permissions);

        return redirect()->route('dashboard.settings.roles.index')->with('success','Berhasil Menambahkan Role Baru');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::orderBy('name','asc')->get();
        return view('dashboard.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,'.$role->id,
            'permissions' => 'required|array|min:1',
        ]);

        $role->update([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        $role->permissions()->sync($request->permissions);

        return redirect()->route('dashboard.settings.roles.index')->with('success','Berhasil Mengubah Role');
    }

    public function destroy(Role $role)
    {
        $action = $role->delete();
        if($action) {
            return response()->json(['status' => 'success','message'=> 'Berhasil Menghapus Role']);
        } else {
            return response()->json(['status' => 'error','message'=> 'Gagal Menghapus Role']);
        }
    }
}
