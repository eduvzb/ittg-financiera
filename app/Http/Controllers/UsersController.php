<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    public function update (Request $request)
    {
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;


        if($request->hasfile('picture'))
        {
            dd('asd');
            $name =  $request->file('picture')->getClientOriginalName();
            $path = $request->file('picture')->storeAs('public/img', $name);
            $user->picture = $name;
        }
        $user->save();

        return response()->json(200);
    }

    public function update_password(Request $request)
    {
        $user = Auth::user();
        //dd($request);
        $validator = Validator::make($request->all(),[
            'old_password' => 'required',
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        if ($validator->fails()) {
            return redirect()->route('users.edit')
                        ->withErrors($validator);
        }

        if( !Hash::check($request->old_password , $user->password))
        {
            return redirect()->route('users.edit')
            ->with('error','Contraseña no coincide con la anterior');
        } 
        $user->password =  Hash::make($request->password);
        $user->save();
        return redirect()
            ->route('users.edit')
            ->with('status', 'Password updated!');
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
