<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index(){
        $data['title'] = 'Profile';
        $data['profile'] = User::with('role')->find(Auth::user()->id);
        return view('profile.index',$data);
    }

    public function profileStore(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
        ], [
            'name.required' => 'Nama tidak boleh kosong!',
            'email.required' => 'Email tidak boleh kosong!',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        } else {
            User::where('id',$request->id)->update(['name' => $request->name, 'email' => $request->email]);
            return response()->json([ 'success' => 'Berhasil menyimpan data.']);
        }
    }
    
    public function passwordStore(Request $request){
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'newpassword' => 'required',
            'renewpassword' => 'required',
        ], [
            'password.required' => 'Current Password tidak boleh kosong!',
            'newpassword.required' => 'New Password tidak boleh kosong!',
            'renewpassword.required' => 'Re-enter New Password tidak boleh kosong!',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        } else {
            $oldData = User::find($request->id_password);
            if(!Hash::check($request->password, $oldData->password)){
                return response()->json([ 'errors' => ['Password lama tidak sama!']]); 
            }else{
                if($request->newpassword != $request->renewpassword){
                    return response()->json([ 'errors' => ['Password baru tidak sama!']]);
                }else{
                    User::where('id',$request->id_password)->update(['password' => Hash::make($request->newpassword)]);
                    return response()->json([ 'success' => 'Berhasil menyimpan data.']);
                }
            }
        }
    }

    public function fotoStore(Request $request){
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:jpg,jpeg,png',
        ], [
            'file.required' => 'Pilih foto terlebih dahulu',
            'file.mimes' => 'Format foto harus jpg,jpeg,png',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        } else {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $location = 'foto';
            $file->move($location, $filename);

            User::where('id', Auth::user()->id)->update(['foto' => $filename]);

            return response()->json(['success' => 'Berhasil menyimpan data.']);
        }  
    }

    public function deleteFoto(){
        $user = User::find(Auth::user()->id);
        unlink('foto/' . $user->foto);
        User::where('id', Auth::user()->id)->update(['foto' => null]);
        return back();
    }
}
