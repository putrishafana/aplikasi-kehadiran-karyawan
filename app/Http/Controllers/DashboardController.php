<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;


class DashboardController extends Controller
{
    public function index(){
        $today = date("Y-m-d");
        $thisMonth = date("m") * 1;
        $thisYear = date("Y");
        $nik = Auth::guard('karyawan')->user()->nik;
        $karyawan = Karyawan::where('nik', $nik)->first();
        $getNama = $karyawan->nama;
        $getDivisi = $karyawan->divisi;
        $attToday = DB::table('attandance')->where('nik', $nik)->where('tanggal', $today)->first();
        $historyMonth = DB::table('attandance')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tanggal)="'. $thisMonth . '"' )
            ->whereRaw('YEAR(tanggal)="' . $thisYear . '"')
            ->orderBy('tanggal')
            ->get();
        $bulan = [" ", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $rekap = DB::table('attandance')
            ->selectRaw('COUNT(nik) as jmlHadir, SUM(if(clock_in > "09:00",1,0)) as jmlTelat')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tanggal)="'. $thisMonth . '"' )
            ->whereRaw('YEAR(tanggal)="' . $thisYear . '"')
            ->first();

        $rekapizin = DB::table('izin')
            ->selectRaw('SUM(IF(status="i",1,0)) as jmlizin, SUM(IF(status="s",1,0)) as jmlsakit')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tgl_mulai)="'. $thisMonth . '"' )
            ->whereRaw('YEAR(tgl_mulai)="' . $thisYear . '"')
            ->where('approve', 1)
            ->first();

        return view('dashboard.dashboard', compact('attToday', 'historyMonth', 'bulan', 'thisMonth', 'thisYear', 'rekap',
        'getNama', 'getDivisi', 'rekapizin'));
    }

    public function admin(){
        $id = Auth::guard('user')->user()->id;
        $user = DB::table('users')->where('id', $id)->first();

        $today = date("Y-m-d");
        $rekap = DB::table('attandance')
            ->selectRaw('COUNT(nik) as jmlHadir, SUM(if(clock_in > "09:00",1,0)) as jmlTelat')
            ->where("tanggal", $today)
            ->first();

        $tgl_mulai = DB::table('izin')->select('tgl_mulai')->first()->tgl_mulai;
        $tgl_selesai = DB::table('izin')->select('tgl_selesai')->first()->tgl_selesai;
        $izin = [];
        $sakit = [];
        $currentDate = \Carbon\Carbon::parse($tgl_mulai);
        while ($currentDate <= \Carbon\Carbon::parse($tgl_selesai)) {
            $jmlizin = DB::table('izin')
                            ->where('tgl_mulai', '<=', $currentDate)
                            ->where('tgl_selesai', '>=', $currentDate)
                            ->where('approve', 1)
                            ->count();
            $jmlsakit = DB::table('izin')
                            ->where('tgl_mulai', '<=', $currentDate)
                            ->where('tgl_selesai', '>=', $currentDate)
                            ->where('approve', 1)
                            ->where('status', 's') // Hanya menghitung sakit
                            ->count();

            $izin[$currentDate->format('Y-m-d')] = $jmlizin;
            $sakit[$currentDate->format('Y-m-d')] = $jmlsakit;

            $currentDate->addDay();
        }



        $jmlkaryawan = DB::table('karyawan')
            ->selectRaw('COUNT(nik) as jmlKaryawan')
            ->count();

        $jmlwfh = DB::table('attandance')
            ->where("tanggal", $today)
            ->where('desc', 'WFH')
            ->count();

        return view('dashboard.panel', compact('rekap', 'jmlizin', 'jmlsakit', 'jmlkaryawan', 'jmlwfh', 'user'));
    }

    public function editProfil()
    {
        $id = Auth::guard('user')->user()->id;
        $user = DB::table('user')->where('id', $id)->first();

        return view('dashboard.panel', compact('user'));
    }

    public function update(Request $request){
        $id = Auth::guard('user')->user()->id;
        $nama = $request->name;
        $email = $request->email;
        $no_telp = $request->no_telp;
        $pass = Hash::make($request->password);
        $users = DB::table('users')->where('id', $id)->first();


        if($request->hasFile('profil')){
            $profil = $id. ".". $request->file('profil')->getClientOriginalExtension();
        }else{
            $profil = $users->profil;
        }

        if(empty($request->password)){
            $data = [
                'name'=> $nama,
                'email' => $email,
                'no_telp' => $no_telp,
                'profil' => $profil
            ];
        }else{
            $data = [
                'name'=> $nama,
                'email' => $email,
                'profil' => $profil,
                'no_telp' => $no_telp,
                'password' => $pass
            ];
        }
        $update = DB::table('users')->where('id', $id)->update($data);
        if($update){
            if($request->hasFile('profil')){
                $folderPath = "public/upload/users/";
                $request->file('profil')->storeAs($folderPath, $profil);
            }
            return Redirect::back()->with(["success" => "Profil Berhasil di Update"]);
        }else{
            return Redirect::back()->with(["error" => "Profil Gagal di Update"]);
        }
    }
}
