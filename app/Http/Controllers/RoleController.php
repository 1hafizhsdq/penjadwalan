<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index()
    {
        $data['title'] = 'Role';
        return view('admin.role.index',$data);
    }

    public function listRole(){
        $data = Role::get();
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

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required',
        ], [
            'role.required' => 'Role tidak boleh kosong!',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        } else {
            if($request->id == null){
                Role::create(['role' => $request->role]);
            }else{
                Role::where('id',$request->id)->update(['role' => $request->role]);
            }
            return response()->json([ 'success' => 'Berhasil menyimpan data.']);
        }
    }

    public function show(Role $role)
    {
        //
    }

    public function edit(Role $role)
    {
        $data = Role::find($role);
        return response()->json($data);
    }

    public function update(Request $request, Role $role)
    {
        //
    }

    public function destroy(Role $role)
    {
        Role::find($role->id)->delete();
        return response()->json(['success' => 'berhasil menghapus data']);
    }
}
