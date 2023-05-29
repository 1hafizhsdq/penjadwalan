<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

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
        $data['jmlPekerjaan'] = Schedule::selectRaw('COUNT(CASE WHEN status = "SELESAI" THEN 1 END) AS selesai')->selectRaw('COUNT(CASE WHEN status is null THEN 1 END) AS berjalan')->first();

        return view('dashboard.index', $data);
    }
}
