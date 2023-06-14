<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

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
        ->rawColumns([])
        ->make(true);
    }

    public function store(Request $request){
        dd($request->all());
        Activity::create([
            'schedule_id' => $request->schedule_id,
            'activity' => $request->activity,
        ]);
        return response()->json([ 'success' => 'Berhasil menyimpan data.']);
    }
}
