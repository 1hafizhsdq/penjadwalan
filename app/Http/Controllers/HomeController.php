<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['title'] = 'Dashboard';
        $jmlPekerjaan = Schedule::selectRaw('COUNT(CASE WHEN status = "SELESAI" THEN 1 END) AS selesai')
                        ->selectRaw('COUNT(CASE WHEN status is null THEN 1 END) AS berjalan')
                        ->selectRaw('COUNT(CASE WHEN status_urgent = "URGENT" AND status is null THEN 1 END) AS urgent');
        if(Auth::user()->role_id != 1){
            $jmlPekerjaan = $jmlPekerjaan->where('user_id',Auth::user()->id);
        }
        $data['jmlPekerjaan'] = $jmlPekerjaan->first();

        $schedule = [];
        $sch = Schedule::with('project')->whereNull('status');
        if(Auth::user()->role_id != 1){
            $sch = $sch->where('user_id',Auth::user()->id);
        }
        $sch = $sch->get();
        foreach($sch as $s){
            $color = null;
            $end = null;
            if(strtotime(date('Y-m-d')) > strtotime($s->due_date)){
                $color = '#E1573A';
                $end = date('Y-m-d');
            }else{
                $color = '#30CF57';
                $end = $s->due_date;
            }

            $schedule[] = [
                'id' => $s->id,
                'title' => $s->project->project,
                'start' => $s->start_date,
                'end' => $end,
                'color' => $color,
            ];
        }
        $data['events'] = $schedule;

        return view('dashboard.index', $data);
    }

    public function schedule(){
        $data = Schedule::with('project')->whereNull('status');
        if(Auth::user()->role_id != 1){
            $data = $data->where('user_id',Auth::user()->id);
        }
        $data = $data->get();

        return response()->json($data);
    }
}
