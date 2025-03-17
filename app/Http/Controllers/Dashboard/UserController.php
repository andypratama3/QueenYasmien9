<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:user-view', ['only' => ['index', 'data_table']]),
            new Middleware('permission:user-manage', ['only'=> ['create', 'store', 'edit', 'update']]),
        ];
    }


    public function index()
    {
        return view('dashboard.users.index');
    }

    public function data_table(Request $request)
    {
        $users = User::where('name', '!=', 'superadmin');

        return DataTables::of($users)
            ->addColumn('action', function ($user) {
                $actions = '';
                $actions .= '<a href="' . route('dashboard.settings.users.edit', $user->id) . '" class="btn btn-sm btn-warning me-2 "><i class="bx bxs-edit"></i></a>';
                $actions .= '<button data-id="'.$user['id'].'" class="btn btn-sm btn-danger btn-delete me-2"><i class="bx bxs-trash"></i></button>';
                return $actions;
            })
            ->addColumn('role', function ($user) {
                return $user->roles->first()->name ?? '-';
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $roles = Role::where('name', '!=', 'superadmin')->get();
        return view('dashboard.users.create',compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);



        $user->assignRole($request->role_id);
        return redirect()->route('dashboard.settings.users.index')->with('success', 'Berhasil Menambahkan Pengguna.');
    }

    public function edit(User $user)
    {
        $roles = Role::where('name', '!=', 'superadmin')->get();

        return view('dashboard.users.edit',compact('user','roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        $user->syncRoles($request->role_id);
        return redirect()->route('dashboard.settings.users.index')->with('success', 'Berhasil Mengubah Pengguna.');
    }

    public function destroy(User $user)
    {
        $action = $user->delete();

        if($action) {
            return response()->json(['status' => 'success','message'=> 'Berhasil Menghapus Pengguna']);
        } else {
            return response()->json(['status' => 'error','message'=> 'Gagal Menghapus Pengguna']);
        }
    }
}
