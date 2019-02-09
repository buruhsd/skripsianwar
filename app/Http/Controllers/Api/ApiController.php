<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Schedule;
use Hash;
use Auth;

class ApiController extends Controller
{
    public function login(Request $request){
    	$this->validate($request,[
            'email' => 'required',
            'password' => 'required'
        ]);
        $password = Hash::make($request->password);
        $user = User::where('email', $request->email)->first();
        if (Auth::attempt(['email'=>$request->email,'password'=>$request->password])) {
            return response()->json(['sukses' => true, 'data' => $user]);
        }else{
            return response()->json(['sukses'=> false, 'data' => $request->password]);
        }
    }

    public function register(Request $request){
    	$this->validate($request,[
    		'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'tlp' => 'required'
        ]);

        $data = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'tlp' => $request->tlp,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['sukses' => true, 'data' => $data]);
    }

    public function schedule_list(){
    	$data = Schedule::orderBy('id', 'DESC')->get();

    	return response()->json(['sukses' => true, 'data' => $data]);
    }

    public function schedule_show($id){
    	$data = Schedule::find($id);

    	return response()->json(['sukses' => true, 'data' => $data]);
    }
}
