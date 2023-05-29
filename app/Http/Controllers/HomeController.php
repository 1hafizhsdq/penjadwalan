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
        $jmlPekerjaan = Schedule::selectRaw('COUNT(CASE WHEN status = "SELESAI" THEN 1 END) AS selesai')->selectRaw('COUNT(CASE WHEN status is null THEN 1 END) AS berjalan');
        if(Auth::user()->role_id != 1){
            $jmlPekerjaan = $jmlPekerjaan->where('user_id',Auth::user()->id);
        }
        $data['jmlPekerjaan'] = $jmlPekerjaan->first();

        return view('dashboard.index', $data);
    }
}
