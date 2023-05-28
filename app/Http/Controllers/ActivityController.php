<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = 'Progres Pekerjaan';
        $data['schedule'] = Schedule::with('activity')->find($request->id);

        return view('activity.index',$data);
    }
}
