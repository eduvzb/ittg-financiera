<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function update (Request $request)
    {
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        dd($request->picture);

        $user->save();

        return response()->json(200);
    }

    public function update_password(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(),[
            'old_password' => 'required',
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);
        if ($validator->fails()) {
            return false;
        }

        if( !Hash::check($request->old_password , $user->password))
        {
           return response()->json('Contraseñas no coinciden');
        } 

        $user->password =  Hash::make($request->password);
        $user->save();

        return true;
    }

    private function uploadImage ($file, $title)
    {
        $file64 = $file;
        $title = $title;
        $image = base64_decode($file64);
        try {
            Storage::disk('local')->put('public/'.$title, $image);
            dd($image);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
            
    }
}
