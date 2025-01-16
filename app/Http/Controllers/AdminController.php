<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('users');
        $query->orderBy('name');
        if(!empty($request->name)){
            $query->where('name', 'like', '%' .$request->name . '%');
        }

        $admin = $query->paginate(10);

        return view('master.useradmin.list-admin', compact('admin'));
    }

    public function store(Request $request)
    {
        $id = $request->id;
        $name = $request->name;
        $email = $request->email;
        $no_telp = $request->no_telp;
        $profil = $request->profil;
        $password = Hash::make($email);

        if($request->hasFile('profil')){
            $profil = $id. ".". $request->file('profil')->getClientOriginalExtension();
        }else{
            $profil = null;
        }

        $data = [
            'name' => $name,
            'email' => $email,
            'no_telp' => $no_telp,
            'profil' => $profil,
            'password' => $password
        ];


        $save = DB::table('users')->insert($data);
        if($save){
            if($request->hasFile('profil')){
                $folderPath = "public/upload/users/";
                $request->file('profil')->storeAs($folderPath, $profil);
            }
            return Redirect::back()->with(["success" => "User Berhasil di Tambahkan"]);
        }else{
            return Redirect::back()->with(["error" => "Data User Gagal di Tambahkan"]);
        }
    }


    public function toggleStatus(Request $request)
    {
        $id = $request->id;
        $status = $request->status;

        $user = User::find($id);
        if ($user){
            $user->status = $user->status === 'Aktif' ? 'Nonaktif' : 'Aktif';
            $user->save();

            return Redirect::back()->with(["success" => "Status Akun Berhasil Di Ubah"]);
        }
            return Redirect::back()->with(["error" => "Status Akun Gagal Diubah"]);
    }

    public function resetPassword(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->password = Hash::make($user->email);
        $user->save();

        return Redirect::back()->with(["error" => "Password Akun Berhasil di Reset"]);
    }

    public function delete($id)
    {
        $delete = DB::table('users')->where('id', $id)->delete();
        if($delete){
            return Redirect::back()->with(["success" => "Data Berhasil di Hapus"]);
        }else{
            return Redirect::back()->with(["error" => "Data  Gagal di Hapus"]);
        }
    }

}
