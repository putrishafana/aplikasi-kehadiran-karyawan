<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Models\Karyawan;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {

        $query = Karyawan::query();
        $query->select('karyawan.*', 'nm_divisi');
        $query->select('karyawan.*', 'nm_divisi', 'config_loc.nama_loc as nama_loc');
        $query->join('divisi', 'karyawan.kd_divisi', '=', 'divisi.kd_divisi');
        $query->join('config_loc', 'karyawan.loc_tugas', '=', 'config_loc.id');
        $query->orderBy('nama');
        if(!empty($request->nama)){
            $query->where('nama', 'like', '%' .$request->nama . '%');
        }

        if(!empty($request->id_divisi)){
            $query->where('karyawan.kd_divisi', $request->kd_divisi);
        }

        $karyawan = $query->paginate(10);

        $divisi = DB::table('divisi')->get();
        $loc_tugas = DB::table('config_loc')->orderBy('id')->get();
        return view('master.karyawan.listkaryawan', compact('karyawan', 'divisi', 'loc_tugas'));
    }

    public function store(Request $request)
    {
        $nik = $request->nik;
        $nama = $request->nama;
        $email = $request->email;
        $no_telp = $request->no_telp;
        $password = Hash::make($nik);
        $kd_divisi = $request->kd_divisi;
        $divisi = $request->divisi;
        $loc_tugas = $request->loc_tugas;

        if($request->hasFile('foto')){
            $foto = $nik. ".". $request->file('foto')->getClientOriginalExtension();
        }else{
            $foto = null;
        }

        $data = [
            'nik' => $nik,
            'nama' => $nama,
            'email' => $email,
            'no_telp' => $no_telp,
            'password' => $password,
            'kd_divisi' => $kd_divisi,
            'divisi' => $divisi,
            'loc_tugas' => $loc_tugas,
            'foto' => $foto
        ];
        $save = DB::table('karyawan')->insert($data);
        if($save){
            if($request->hasFile('foto')){
                $folderPath = "public/upload/karyawan/";
                $request->file('foto')->storeAs($folderPath, $foto);
            }
            return Redirect::back()->with(["success" => "Karyawan Berhasil di Tambahkan"]);
        }else{
            return Redirect::back()->with(["error" => "Data Karyawan Gagal di Tambahkan"]);
        }
    }

    public function update(Request $request)
    {
        $nik = $request->nik;
        $divisi = DB::table('divisi')->get();
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        $loc_tugas = DB::table('config_loc')->orderBy('id')->get();
        return view('master.karyawan.form-update', compact('divisi', 'karyawan', 'loc_tugas'));
    }

    public function save_update(Request $request, $nik)
    {
        $nik = $request->nik;
        $nama = $request->nama;
        $email = $request->email;
        $no_telp = $request->no_telp;
        $kd_divisi = $request->kd_divisi;
        $divisi = $request->divisi;
        $loc_tugas = $request->loc_tugas;
        $old_foto = $request->old_foto;
        if($request->hasFile('foto')){
            $foto = $nik. ".". $request->file('foto')->getClientOriginalExtension();
        }else{
            $foto = $old_foto;
        }

        $data = [
            'nama' => $nama,
            'email' => $email,
            'no_telp' => $no_telp,
            'kd_divisi' => $kd_divisi,
            'divisi' => $divisi,
            'loc_tugas' => $loc_tugas,
            'foto' => $foto
        ];
        $update = DB::table('karyawan')->where('nik', $nik)->update($data);
        if($update){
            if($request->hasFile('foto')){
                $folderPath = "public/upload/karyawan/";
                $folderPathOld = "public/upload/karyawan/" . $old_foto;
                Storage::delete($folderPathOld);
                $request->file('foto')->storeAs($folderPath, $foto);
            }
            return Redirect::back()->with(["success" => "Data Berhasil di Update"]);
        }else{
            return Redirect::back()->with(["error" => "Data  Gagal di Update"]);
        }
    }

    public function view(Request $request)
    {
        $nik = $request->nik;
        $divisi = DB::table('divisi')->get();
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        return view('master.karyawan.form-view', compact('divisi', 'karyawan'));
    }

    public function delete($nik)
    {
        $delete = DB::table('karyawan')->where('nik', $nik)->delete();
        if($delete){
            return Redirect::back()->with(["success" => "Data Berhasil di Hapus"]);
        }else{
            return Redirect::back()->with(["error" => "Data  Gagal di Hapus"]);
        }
    }

}

