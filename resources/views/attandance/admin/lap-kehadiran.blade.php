@extends('layouts.admin.master')
@section('content')
<div class="sticky-top">
    <div class="page-heading">
        <h3>Laporan Kehadiran</h3>
    </div>
</div>

<div class="card">
    <div class="card-body px-4 py-4-5">
       <form action="/panel/print-lap" target="_blank" method="POST" onsubmit="return validateForm();">
           @csrf
           <div class="row">
               <div class="col-4">
                   <div class="form-group">
                       <select name="month" id="month" class="form-select">
                           <option value="">Bulan</option>
                           @for ($i=1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ date('m') == $i ? 'selected' : '' }}>{{ $month[$i] }}</option>
                        @endfor
                       </select>
                   </div>
               </div>
               <div class="col-4">
                <div class="form-group">
                    <select name="year" id="year" class="form-select">
                        <option value="">Tahun</option>
                        @php
                            $tahun = 2020;
                            $thisYear = date('Y');
                        @endphp
                        @for ($t=$tahun; $t <= $thisYear; $t++)
                            <option value="{{ $t }}" {{ date('Y') == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <select name="nik" id="nik" class="form-select">
                        <option value="">Karyawan</option>
                        @foreach ($karyawan  as $k)
                            <option value="{{ $k->nik }}">{{ $k->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
           </div>

            <div class="row">
            <div class="col-12 text-end">
                <!-- Tombol-tombol Anda akan berada di sini -->
                <button type="submit" class="btn" style="background-color: rgb(12, 12, 82); color: white"><i class="fa-solid fa-print"></i> Rekap Kehadiran Peserta</button>
                {{-- <button type="submit" class="btn" style="background-color: rgb(9, 56, 15); color: white"><i class="fa-solid fa-file-excel"></i> Eksport to Excel</button> --}}
            </div>
        </div>
            </div>



       </form>
    </div>
</div>
@endsection
<script>
    function validateForm() {
        var nik = document.getElementById("nik").value;
        if (nik === '') {
            alert("Anda Belum Memilih Karyawan!");
            return false;
        }
        return true;
    }
</script>
