<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Models\Divisi;


class DivisiController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('divisi');
        if(!empty($request->nm_divisi)){
            $query->where('nm_divisi', 'like', '%' .$request->nm_divisi . '%');
        }
        $divisi = $query->paginate(5);
        return view('master.divisi.list-divisi', compact('divisi'));
    }

    public function store(Request $request)
    {
        $kd_divisi = $request->kd_divisi;
        $nm_divisi = $request->nm_divisi;

        $data = [
            'kd_divisi' => $kd_divisi,
            'nm_divisi' => $nm_divisi,
        ];

        $save = DB::table('divisi')->insert($data);
        if($save){
            return Redirect::back()->with(["success" => "Data Berhasil di Tambahkan"]);
        }else{
            return Redirect::back()->with(["error" => "Data  Gagal di Tambahkan"]);
        }
    }

    public function update(Request $request)
    {
        $kode = $request->kd_divisi;
        $divisi = DB::table('divisi')->where('kd_divisi', $kode)->first();
        return view('master.divisi.edit-divisi', compact('divisi'));
    }

    public function save_update(Request $request, $kd_divisi)
    {
        $nm_divisi = $request->nm_divisi;
        $data = [
            'nm_divisi' => $nm_divisi
        ];

        $update = DB::table('divisi')->where('kd_divisi', $kd_divisi)->update($data);

        if($update){
            return Redirect::back()->with(["success" => "Data Berhasil di Update"]);
        } else {
            return Redirect::back()->with(["error" => "Data Gagal di Update"]);
        }
    }

    public function view(Request $request)
    {
        $kode = $request->kd_divisi;
        $divisi = DB::table('divisi')->where('kd_divisi', $kode)->first();
        return view('master.divisi.view-divisi', compact('divisi'));
    }

    public function delete($kd_divisi)
    {
        $delete = DB::table('divisi')->where('kd_divisi', $kd_divisi)->delete();
        if($delete){
            return Redirect::back()->with(["success" => "Data Berhasil di Hapus"]);
        }else{
            return Redirect::back()->with(["error" => "Data  Gagal di Hapus"]);
        }
    }

}
