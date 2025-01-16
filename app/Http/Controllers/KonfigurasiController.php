<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class KonfigurasiController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('config_loc');
        if(!empty($request->nama_loc)){
            $query->where('nama_loc', 'like', '%' .$request->nama_loc . '%');
        }
        $lokasi = $query->paginate(5);
        return view('konfigurasi.lokasi', compact('lokasi'));
    }

    public function store(Request $request)
    {
        $nama_loc = $request->nama_loc;
        $titik = $request->location;
        $alamat = $request->alamat;
        $radius = $request->radius;

        $data = [
            'nama_loc' => $nama_loc,
            'location' => $titik,
            'alamat' => $alamat,
            'radius' => $radius
        ];

        $save = DB::table('config_loc')->insert($data);
        if($save){
            return Redirect::back()->with(["success" => "Data Berhasil di Tambahkan"]);
        }else{
            return Redirect::back()->with(["error" => "Data  Gagal di Tambahkan"]);
        }
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $lokasi = DB::table('config_loc')->where('id', $id)->first();
        return view('konfigurasi.edit-loc', compact('lokasi'));
    }

    public function save_update(Request $request, $id)
    {
        $nama_loc = $request->nama_loc;
        $titik = $request->location;
        $alamat = $request->alamat;
        $radius = $request->radius;

        $data = [
            'nama_loc' => $nama_loc,
            'location' => $titik,
            'alamat' => $alamat,
            'radius' => $radius
        ];

        $update = DB::table('config_loc')->where('id', $id)->update($data);

        if($update){
            return Redirect::back()->with(["success" => "Data Berhasil di Update"]);
        } else {
            return Redirect::back()->with(["error" => "Data Gagal di Update"]);
        }
    }


    public function delete($id)
    {
        $delete = DB::table('config_loc')->where('id', $id)->delete();
        if($delete){
            return Redirect::back()->with(["success" => "Data Berhasil di Hapus"]);
        }else{
            return Redirect::back()->with(["error" => "Data  Gagal di Hapus"]);
        }
    }
}
