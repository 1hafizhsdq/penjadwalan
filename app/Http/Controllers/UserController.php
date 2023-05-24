<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $data['title'] = 'User';
        $data['role'] = Role::get();
        return view('admin.user.index',$data);
    }

    public function list()
    {
        $data = User::with('role')->get();
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('aksi', function ($data) {
            return '
                <a href="javascript:void(0)" id="btn-delete" onclick="editData('.$data->id.')" class="btn btn-sm btn-warning" data-id="' .$data->id .'" title="Edit Data"><i class="bi bi-pencil-fill"></i></a>
                <a href="javascript:void(0)" id="btn-delete" onclick="deleteData('.$data->id.')" class="btn btn-sm btn-danger" data-id="' .$data->id .'" title="Hapus Data"><i class="bi bi-trash-fill"></i></a>
            ';
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email:rfc,dns',
            'role' => 'required',
            'username' => 'required|alpha_dash|unique:users,username',
        ], [
            'name.required' => 'nama tidak boleh kosong!',
            'email.required' => 'email tidak boleh kosong!',
            'email.email' => 'email salah!',
            'role.required' => 'Role tidak boleh kosong!',
            'username.required' => 'Username tidak boleh kosong',
            'username.alpha_dash' => 'Username tidak boleh mengandung spasi',
            'username.unique' => 'Username sudah ada yang menggunakan',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        } else {
            if($request->id == null){
                User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'username' => $request->username,
                    'password' => Hash::make($request->username),
                    'role_id' => $request->role,
                ]);
            }else{
                User::where('id',$request->id)->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'role_id' => $request->role,
                    'username' => $request->username,
                ]);
            }
            return response()->json([ 'success' => 'Berhasil menyimpan data.']);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data = User::find($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return response()->json(['success' => 'berhasil menghapus data']);
    }
}
