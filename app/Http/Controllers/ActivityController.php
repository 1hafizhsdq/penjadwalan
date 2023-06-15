<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = 'Progres Pekerjaan';
        $data['schedule'] = Schedule::with('activity')->find($request->sch);

        return view('activity.index',$data);
    }

    public function listActivity($id){
        $data = Activity::where('schedule_id',$id)->orderBy('created_at','desc')->get();
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('tgl', function($data){
            return Carbon::parse($data->created_at)->isoFormat('D MMMM Y');
        })
        ->editColumn('progres', function($data){
            return $data->progres.'%';
        })
        ->addColumn('foto', function($data){
            return '<a id="'.$data->id.'"><i class="bi bi-card-image"></i></a>';
        })
        ->rawColumns(['foto'])
        ->make(true);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'files.*' => 'file|mimes:jpg,jpeg,png|max:2048',
        ],[
            'files.max' => 'Foto maksimal berukuran 2MB',
            'files.mimes' => 'Format foto harus jpg,jpeg,png',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $foto = [];
        if ($request->hasFile('files')) {
            $files = $request->file('files');
    
            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();
                $newName = Str::random(40).'.'.$extension;
                $file->storeAs('/public/progress', $newName);
                $foto[] = $newName;
            }
        }

        Activity::create([
            'schedule_id' => $request->schedule_id,
            'activity' => $request->activity,
            'progres' => $request->progres,
            'foto' => json_encode($foto),
        ]);
        return response()->json([ 'success' => 'Berhasil menyimpan data.']);
    }
}
