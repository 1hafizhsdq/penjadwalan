<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        if(Auth::user()->role_id == 1){
            $schedule = Schedule::with('project','user');
        }else{
            $schedule = Schedule::with('project','user')->where('user_id',Auth::user()->id);
        }
        $data = $schedule->orderBy('start_date','desc')->get();
        
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('aksi', function ($data) {
            if($data->status == null){
                return '
                    <a href="javascript:void(0)" id="btn-edit" class="btn btn-sm btn-warning" data-id="' .$data->id .'" title="Edit Data"><i class="bi bi-pencil-fill"></i></a>
                    <a href="/activity?sch='.$data->id.'" id="btn-activity" class="btn btn-sm btn-primary" data-id="' .$data->id .'" title="Progres Data"><i class="bi bi-eye"></i></a>
                    <a href="javascript:void(0)" id="btn-done" class="btn btn-sm btn-success" data-id="' .$data->id .'" title="Selesaikan Pekerjaan"><i class="bi bi-check"></i></a>
                ';
            }else{
                return '
                    <a href="javascript:void(0)" class="btn btn-sm btn-success" title="Selesaikan Pekerjaan">'.$data->status.'</a>
                    <a href="/activity?sch='.$data->id.'" id="btn-activity" class="btn btn-sm btn-primary" data-id="' .$data->id .'" title="Progres Data"><i class="bi bi-eye"></i></a>
                ';
            }
        })
        ->addColumn('project', function ($data) {
            if($data->status == null){
                return '
                    <a href="/activity?sch='.$data->id.'" id="btn-activity" class="" data-id="' .$data->id .'" title="Progres Data">'.$data->project->project.'</a>
                ';
            }else{
                return $data->project->project;
            }
        })
        ->editColumn('start_date', function($data){
            return Carbon::parse($data->start_date)->isoFormat('D MMMM Y');
        })
        ->editColumn('due_date', function($data){
            return Carbon::parse($data->due_date)->isoFormat('D MMMM Y');
        })
        ->editColumn('end_date', function($data){
            if($data->end_date == null){
                return '';
            }else{
                return Carbon::parse($data->end_date)->isoFormat('D MMMM Y');
            }
        })
        ->rawColumns(['aksi','project'])
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

    public function edit(Request $request)
    {
        $data = Schedule::find($request->id);
        return response()->json($data);
    }

    public function done(Request $request)
    {
        Schedule::find($request->uuid)->update([
            'status' => 'SELESAI', 
            'end_date' => date('Y-m-d'),
            'information' => $request->information
        ]);
        return response()->json([ 'success' => 'Berhasil menyimpan data.']);
    }
}
