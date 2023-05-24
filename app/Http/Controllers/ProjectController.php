<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ProjectController extends Controller
{
    public function index()
    {
        $data['title'] = 'Project';
        return view('admin.project.index',$data);
    }

    public function listProject(){
        $data = Project::get();
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
            'project' => 'required',
        ], [
            'project.required' => 'Project tidak boleh kosong!',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        } else {
            if($request->id == null){
                Project::create(['project' => $request->project]);
            }else{
                Project::where('id',$request->id)->update(['project' => $request->project]);
            }
            return response()->json([ 'success' => 'Berhasil menyimpan data.']);
        }
    }

    public function show(Project $project)
    {
        //
    }

    public function edit(Project $project)
    {
        $data = Project::find($project);
        return response()->json($data);
    }

    public function update(Request $request, Project $project)
    {
        //
    }

    public function destroy(Project $project)
    {
        Project::find($project->id)->delete();
        return response()->json(['success' => 'berhasil menghapus data']);
    }
}
