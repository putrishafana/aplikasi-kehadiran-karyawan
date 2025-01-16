<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use app\Models\Izin;

class AttandanceController extends Controller
{
    public function create()
    {
        $today = date('Y-m-d');
        $nik = Auth::guard('karyawan')->user()->nik;
        $check = DB::table('attandance')->where('tanggal', $today)->where('nik', $nik)->count();
        $id_loc = Auth::guard('karyawan')->user()->loc_tugas;
        $location = DB::table('config_loc')->where("id", $id_loc)->first();
        $metode = '';
        if ($check > 0) {
            $last_attendance = DB::table('attandance')
                ->where('tanggal', $today)
                ->where('nik', $nik)
                ->orderBy('desc')
                ->first();
            $metode = $last_attendance->desc ?? '';
        }
        return view('attandance.create', compact('check', 'location', 'metode'));
    }

    public function store(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tanggal = date("Y-m-d");
        $clock = date("H:i:s");
        $id_loc = Auth::guard('karyawan')->user()->loc_tugas;
        $location = DB::table('config_loc')->where("id", $id_loc)->first();
        $lok = explode(",", $location->location);
        $lat_kantor = $lok[0];
        $long_kantor = $lok[1];
        $lokasi = $request->loc;
        $loc_user = explode(",", $lokasi);
        $lat_user = $loc_user[0];
        $long_user = $loc_user[1];
        $metode = $request->metode;

        if ($metode == "WFO") {
            $jarak = $this->distance($lat_kantor, $long_kantor, $lat_user, $long_user);
            $radius = round($jarak["meters"]);

            if ($radius >= $location->radius) {
                return "error|Maaf, Anda Tidak Berada di Area Radius Kantor!";
            }
        }

        $check = DB::table('attandance')->where('tanggal', $tanggal)->where('nik', $nik)->count();

        if ($check > 0) {
            $ket = "out";
            $last_attendance = DB::table('attandance')
                ->where('tanggal', $tanggal)
                ->where('nik', $nik)
                ->orderBy('tanggal', 'desc')
                ->first();
            $metode = $last_attendance->desc ?? '';
        } else {
            $ket = "in";
        }

        $image = $request->image;
        $folderPath = "public/upload/attandance/";
        $picName = $nik."-".$tanggal."-".$ket;
        $image_parts = explode(";base64", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $picName . ".png";
        $file = $folderPath.$fileName;
        $id = rand(0, 99999999);


        if($check > 0){
            $data_out = [
            'clock_out' => $clock,
            'pic_out' => $fileName,
            'loc_out' => $lokasi,
            'desc' => $metode
            ];
                $update = DB::table('attandance')->where('tanggal', $tanggal)->where('nik', $nik)->update($data_out);
                if($update){
                    echo "Success|Terimakasih, selamat beristirahat|out";
                    Storage::put($file, $image_base64);
                }else{
                    echo "error|Kehadiran gagal di input|out ";
                }
            }else{
                $data_in = [
                    'attandance_id' => $id,
                    'nik' => $nik,
                    'tanggal' => $tanggal,
                    'clock_in' => $clock,
                    'pic_in' => $fileName,
                    'loc_in' => $lokasi,
                    'desc' => $metode
                ];
                $add_in = DB::table('attandance')->insert($data_in);
                if($add_in){
                    echo "Success|Terimakasih, semangat bekerja|in";
                    Storage::put($file, $image_base64);
                }else{
                    echo "error|Kehadiran gagal di input|out ";
                }
             }
        }



    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }

    public function getLoc($id)
    {
        $location = DB::table('config_loc')->findOrFail($id);

        $response = [
            'location' => $location->location,
            'radius' => $location->radius,
        ];

        return response()->json($response);
    }


    public function editProfil(){
        $nik = Auth::guard('karyawan')->user()->nik;
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();


        return view('attandance.editProfil', compact('karyawan'));
    }

    public function update(Request $request){
        $nik = Auth::guard('karyawan')->user()->nik;
        $nama = $request->nama;
        $no_telp = $request->no_telp;
        $pass = Hash::make($request->password);
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();


        if($request->hasFile('foto')){
            $foto = $nik. ".". $request->file('foto')->getClientOriginalExtension();
        }else{
            $foto = $karyawan->foto;
        }

        if(empty($request->password)){
            $data = [
                'nama'=> $nama,
                'no_telp' => $no_telp,
                'foto' => $foto
            ];
        }else{
            $data = [
                'nama'=> $nama,
                'no_telp' => $no_telp,
                'foto' => $foto,
                'password' => $pass
            ];
        }
        $update = DB::table('karyawan')->where('nik', $nik)->update($data);
        if($update){
            if($request->hasFile('foto')){
                $folderPath = "public/upload/karyawan/";
                $request->file('foto')->storeAs($folderPath, $foto);
            }
            return Redirect::back()->with(["success" => "Profil Berhasil di Update"]);
        }else{
            return Redirect::back()->with(["error" => "Profil Gagal di Update"]);
        }
    }

    public function history(){
        $bulan = [" ", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        return view('attandance.histori', compact('bulan'));
    }

    public function getHistory(Request $request){
        $month = $request->month;
        $year = $request->year;
        $nik = Auth::guard('karyawan')->user()->nik;

        $history = DB::table('attandance')
        ->whereRaw('MONTH(tanggal)="'. $month . '"' )
        ->whereRaw('YEAR(tanggal)="' . $year . '"')
        ->where('nik', $nik)
        ->orderBy('tanggal')
        ->get();

        return view('attandance.getHistory', compact('history'));
    }

    public function izin(){
        $nik = Auth::guard('karyawan')->user()->nik;
        $dataizin = DB::table('izin')->where('nik', $nik)->get();
        return view('attandance.cuti', compact('dataizin'));
    }

    public function createIzin(){

        return view('attandance.createIzin');
    }

    public function submitIzin(Request $request)
    {
        $id = $request->id;
        $izin = DB::table('izin')->where('id', $id)->first();
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_mulai = $request->tgl_mulai;
        $jml_hari = $request->jml_hari;
        $tgl_selesai = $request->tgl_selesai;
        $status = $request->status;
        $keterangan = $request->keterangan;
        $dokumen = $request->bukti_sakit;

        if($status === "i"){
            $data = [
                'nik' => $nik,
                'tgl_mulai' => $tgl_mulai,
                'tgl_selesai' => $tgl_selesai,
                'jml_hari' => $jml_hari,
                'status' => $status,
                'keterangan' => $keterangan,
                'bukti_sakit' => null,
            ];
        }elseif($status === "s"){
            if($request->hasFile('bukti_sakit')){
                $bukti_sakit = $request->file('bukti_sakit');
                $bukti_sakit_path = $bukti_sakit->store('upload/izin', 'public');

                $data = [
                    'nik' => $nik,
                    'tgl_mulai' => $tgl_mulai,
                    'tgl_selesai' => $tgl_selesai,
                    'jml_hari' => $jml_hari,
                    'status' => $status,
                    'keterangan' => null,
                    'bukti_sakit' => $bukti_sakit_path,
                ];
            }else{
                return redirect('/attandance/izin')->with(['error' => 'Mohon unggah surat sakit Anda']);
            }
        }else{
            return redirect('/attandance/izin')->with(['error' => 'Status izin atau sakit tidak valid']);
        }
        $submit = DB::table('izin')->insert($data);
        if ($submit) {
            return redirect('/attandance/izin')->with(['success' => 'Pengajuan Izin atau Sakit Berhasil! Mohon Menunggu Persetujuan!']);
        } else {
            return redirect('/attandance/izin')->with(['error' => 'Pengajuan Izin atau Sakit Gagal!']);
        }
    }



    public function batalPengajuan($id)
    {
        $batal = DB::table('izin')->where('id', $id)->delete();

        if ($batal) {
            return redirect('/attandance/izin')->with(['success' => 'Pengajuan Berhasil Di Batalkan!']);
        } else {
            return redirect('/attandance/izin')->with(['error' => 'Tidak dapat membatalkan pengajuan yang telah disetujui atau ditolak.']);
        }
    }



    // BAGIAN CONTROLLER ADMINISTRATOR

    public function monitoring()
    {

        return view('attandance.admin.monitoring');
    }

    public function getData(Request $request)
    {
        $tanggal = $request->tanggal;

        $att = DB::table('attandance')
        ->select('attandance.*', 'nama', 'divisi')
        ->join('karyawan', 'attandance.nik', 'karyawan.nik')
        ->join('divisi', 'karyawan.kd_divisi', 'divisi.kd_divisi')
        ->where('tanggal', $tanggal)
        ->get();


        return view('attandance.admin.getData', compact('att'));
    }


    public function viewMaps(Request $request)
    {
        $id = $request->attandance_id;
        $att = DB::table('attandance')->where('attandance_id', $id)
        ->join('karyawan', 'attandance.nik', 'karyawan.nik')
        ->first();
        return view('attandance.admin.maps', compact('att'));
    }

    public function lap_kehadiran()
    {
        $month = [" ", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $karyawan = DB::table('karyawan')->orderBy('nama')->get();

        return view('attandance.admin.lap-kehadiran', compact('month', 'karyawan'));
    }

    public function print(Request $request)
    {
        $nik = $request->nik;
        $month = $request->month;
        $year = $request->year;
        $name_month = [" ", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $karyawan = DB::table('karyawan')->where('nik', $nik)
        ->first();
        $att = DB::table('attandance')
        ->where('nik', $nik)
        ->whereRaw('MONTH(tanggal)="'. $month . '"' )
        ->whereRaw('YEAR(tanggal)="' . $year . '"')
        ->orderBy('tanggal', 'asc')
        ->get();
        return view('attandance.admin.print-lap', compact('month', 'year', 'name_month', 'karyawan', 'att'));
    }

    public function rekap_kehadiran()
    {
        $month = [" ", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('attandance.admin.rekap_kehadiran', compact('month'));
    }


    public function rekap(Request $request)
    {
        $month = $request->month;
        $name_month = [" ", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $year = $request->year;
        $rekap = DB::table('attandance')
        ->selectRaw('attandance.nik,nama,
        MAX(IF(DAY(tanggal) = 1, concat(clock_in,"-",ifnull(clock_out, "00:00:00")), "")) as tanggal_1,
        MAX(IF(DAY(tanggal) = 2, concat(clock_in,"-",ifnull(clock_out, "00:00:00")), "")) as tanggal_2,
        MAX(IF(DAY(tanggal) = 3, concat(clock_in,"-",ifnull(clock_out, "00:00:00")), "")) as tanggal_3,
        MAX(IF(DAY(tanggal) = 4, concat(clock_in,"-",ifnull(clock_out, "00:00:00")), "")) as tanggal_4,
        MAX(IF(DAY(tanggal) = 5, concat(clock_in,"-",ifnull(clock_out, "00:00:00")), "")) as tanggal_5,
        MAX(IF(DAY(tanggal) = 6, concat(clock_in,"-",ifnull(clock_out, "00:00:00")), "")) as tanggal_6,
        MAX(IF(DAY(tanggal) = 7, concat(clock_in,"-",ifnull(clock_out, "00:00:00")), "")) as tanggal_7,
        MAX(IF(DAY(tanggal) = 8, concat(clock_in,"-",ifnull(clock_out, "00:00:00")), "")) as tanggal_8,
        MAX(IF(DAY(tanggal) = 9, concat(clock_in,"-",ifnull(clock_out, "00:00:00")), "")) as tanggal_9,
        MAX(IF(DAY(tanggal) = 10, concat(clock_in,"-",ifnull(clock_out, "00:00:00")), "")) as tanggal_10,
        MAX(IF(DAY(tanggal) = 11, concat(clock_in,"-",ifnull(clock_out, "00:00:00")), "")) as tanggal_11,
        MAX(IF(DAY(tanggal) = 12, concat(clock_in,"-",ifnull(clock_out, "00:00:00")), "")) as tanggal_12,
        MAX(IF(DAY(tanggal) = 13, concat(clock_in,"-",ifnull(clock_out, "00:00:00")), "")) as tanggal_13,
        MAX(IF(DAY(tanggal) = 14, concat(clock_in,"-",ifnull(clock_out, "00:00:00")), "")) as tanggal_14,
        MAX(IF(DAY(tanggal) = 15, concat(clock_in,"-",ifnull(clock_out, "00:00:00")), "")) as tanggal_15,
        MAX(IF(DAY(tanggal) = 16, concat(clock_in,"-",ifnull(clock_out, "00:00:00")), "")) as tanggal_16,
        MAX(IF(DAY(tanggal) = 17, concat(clock_in,"-",ifnull(clock_out, "00:00:00")), "")) as tanggal_17,
        MAX(IF(DAY(tanggal) = 18, concat(clock_in,"-",ifnull(clock_out, "00:00:00")), "")) as tanggal_18,
        MAX(IF(DAY(tanggal) = 19, concat(clock_in,"-",ifnull(clock_out, "00:00:00")), "")) as tanggal_19,
        MAX(IF(DAY(tanggal) = 20, concat(clock_in,"-",ifnull(clock_out, "00:00:00")), "")) as tanggal_20,
        MAX(IF(DAY(tanggal) = 21, concat(clock_in,"-",ifnull(clock_out, "00:00:00")), "")) as tanggal_21,
        MAX(IF(DAY(tanggal) = 22, concat(clock_in,"-",ifnull(clock_out, "00:00:00")), "")) as tanggal_22,
        MAX(IF(DAY(tanggal) = 23, concat(clock_in,"-",ifnull(clock_out, "00:00:00")), "")) as tanggal_23,
        MAX(IF(DAY(tanggal) = 24, concat(clock_in,"-",ifnull(clock_out, "00:00:00")), "")) as tanggal_24,
        MAX(IF(DAY(tanggal) = 25, concat(clock_in,"-",ifnull(clock_out, "00:00:00")), "")) as tanggal_25,
        MAX(IF(DAY(tanggal) = 26, concat(clock_in,"-",ifnull(clock_out, "00:00:00")), "")) as tanggal_26,
        MAX(IF(DAY(tanggal) = 27, concat(clock_in,"-",ifnull(clock_out, "00:00:00")), "")) as tanggal_27,
        MAX(IF(DAY(tanggal) = 28, concat(clock_in,"-",ifnull(clock_out, "00:00:00")), "")) as tanggal_28,
        MAX(IF(DAY(tanggal) = 29, concat(clock_in,"-",ifnull(clock_out, "00:00:00")), "")) as tanggal_29,
        MAX(IF(DAY(tanggal) = 30, concat(clock_in,"-",ifnull(clock_out, "00:00:00")), "")) as tanggal_30,
        MAX(IF(DAY(tanggal) = 31, concat(clock_in,"-",ifnull(clock_out, "00:00:00")), "")) as tanggal_31')
        ->join('karyawan', 'attandance.nik','=','karyawan.nik')
        ->whereRaw('MONTH(tanggal)="'. $month . '"' )
        ->whereRaw('YEAR(tanggal)="' . $year . '"')
        ->groupByRaw('attandance.nik,nama')
        ->get();

        return view('attandance.admin.cetak-rekap', compact('month', 'year', 'rekap', 'name_month'));
    }

    public function approvalIzin(Request $request)
    {

        $query = DB::table('izin')
        ->join('karyawan', 'izin.nik', '=', 'karyawan.nik')
        ->orderBy('tgl_mulai', 'desc');

        if (!empty($request->nama)) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }
        $query->whereDate('tgl_mulai', '>=', now()->toDateString());

        $izinsakit = $query->paginate(10);

        return view('attandance.admin.izin', compact('izinsakit'));
    }

    public function approve(Request $request)
    {
        $approve = $request->approve;
        $id_approve_form = $request->id_approve_form;
        $update = DB::table('izin')->where('id', $id_approve_form)->update([
            "approve" => $approve
        ]);
        if($update){
            return Redirect::back()->with(["success" => "Data Berhasil di Update"]);
        }else{
            return Redirect::back()->with(["error" => "Data Gagal di Update"]);
        }
    }

    public function batalApprove($id)
    {
        $update = DB::table('izin')->where('id', $id)->update([
            "approve" => 0
        ]);
        if($update){
            return Redirect::back()->with(["success" => "Data Berhasil di Update"]);
        }else{
            return Redirect::back()->with(["error" => "Data Gagal di Update"]);
        }
    }

}
