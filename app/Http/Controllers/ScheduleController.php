<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ScheduleController extends Controller
{
    public function index()
    {
        $data['title'] = 'Jadwal Pekerjaan';
        $data['projects'] = Project::orderBy('created_at','desc')->get();
        $data['users'] = User::whereNot('role_id',1)->get();
        return view('schedule.index',$data);
    }

    public function listSchedule(){
        $data = Schedule::get();
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

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'start_date' => 'required',
            'due_date' => 'required',
            'user_id' => 'required',
            'project_id' => 'required',
        ], [
            'start_date.required' => 'Tanggal Mulai tidak boleh kosong!',
            'due_date.required' => 'Deadline tidak boleh kosong!',
            'user_id.required' => 'Engineer tidak boleh kosong!',
            'project_id.required' => 'Project tidak boleh kosong!',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        } else {
            if($request->id == null){
                Schedule::create([
                    'start_date' => $request->start_date,
                    'due_date' => $request->due_date,
                    'user_id' => $request->user_id,
                    'project_id' => $request->project_id,
                ]);
            }else{
                Schedule::where('id',$request->id)->update([
                    'start_date' => $request->start_date,
                    'due_date' => $request->due_date,
                    'user_id' => $request->user_id,
                    'project_id' => $request->project_id,
                ]);
            }
            return response()->json([ 'success' => 'Berhasil menyimpan data.']);
        }
    }
}
