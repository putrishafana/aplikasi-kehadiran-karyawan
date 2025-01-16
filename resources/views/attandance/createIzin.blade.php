@extends('layouts.app')
@section('header')
<div class="appHeader text-light" style="background-color: #445a79">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Form Pengajuan</div>
    <div class="right"></div>
</div>
@endsection

@section('content')
<style>
    .scrollable-content {
        height: calc(100vh - 50px);
        overflow-y: auto;
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<div class="scrollable-content">
<div class="row" style="margin-top: 4rem">
    <div class="col">
        <form action="/attandance/submitizin" method="POST" id="formizin" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="tgl_mulai">Tanggal Mulai</label>
                        <input type="text" class="form-control" id="tgl_mulai" name="tgl_mulai" placeholder="Tanggal Mulai" autocomplete="off">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="tgl_selesai">Tanggal Selesai</label>
                        <input type="text" class="form-control" id="tgl_selesai" name="tgl_selesai" placeholder="Tanggal Selesai" autocomplete="off">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="jml_hari">Jumlah Hari</label>
                        <input type="text" class="form-control" id="jml_hari" name="jml_hari" placeholder="Jumlah Hari" readonly style="background: white" autocomplete="off">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" name="status" id="status" onchange="toggleFields()">
                            <option value="">--pilih status--</option>
                            <option value="i">Izin</option>
                            <option value="s">Sakit</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row" id="keteranganRow" style="display: none;">
                <div class="col">
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea id="keterangan" name="keterangan" type="text" cols="30" rows="3" class="form-control" placeholder=""></textarea>
                    </div>
                </div>
            </div>

            <div class="custom-file-upload" id="fileUploadRow" style="display: none;">
                <input type="file" name="bukti_sakit" id="bukti_sakit" accept=".png, .jpg, .jpeg">
                <label for="bukti_sakit">
                    <span>
                        <strong>
                            <ion-icon name="cloud-upload-outline" role="img" class="md hydrated" aria-label="cloud upload outline"></ion-icon>
                            <i>Tap to Upload</i>
                        </strong>
                    </span>
                </label>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <button class="btn w-100" style="background-color: #445a79; color: white">
                            <ion-icon name="send-outline"></ion-icon>Submit</button>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
</div>
@endsection

@push('myscript')
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<script>
    $('#formizin').submit(function(){
    var tgl_mulai = $('#tgl_mulai').val();
    var tgl_selesai = $('#tgl_selesai').val();
    var status = $('#status').val();
    var keterangan = $('#keterangan').val();
    var file = $('#bukti_sakit').val(); // Ambil nilai file yang diunggah oleh pengguna

    if(tgl_mulai == ""){
        Swal.fire({
        title: 'Oops!',
        text: 'Tanggal Tidak Boleh Kosong',
        icon: 'warning',
        });
        return false;
    }else if(tgl_selesai == ""){
        Swal.fire({
        title: 'Oops!',
        text: 'Tanggal Tidak Boleh Kosong',
        icon: 'warning',
        });
        return false;
    }else if(status == ""){
        Swal.fire({
        title: 'Oops!',
        text: 'Status Tidak Boleh Kosong',
        icon: 'warning',
        });
        return false
    }else if(keterangan == "" && file == ""){
        Swal.fire({
        title: 'Oops!',
        text: 'Keterangan atau File Tidak Boleh Kosong',
        icon: 'warning',
        });
        return false;
    }
})


    function toggleFields() {
        var status = document.getElementById("status").value;
        var keteranganRow = document.getElementById("keteranganRow");
        var fileUploadRow = document.getElementById("fileUploadRow");

        if (status === "i") {
            keteranganRow.style.display = "block";
            fileUploadRow.style.display = "none";
        } else if (status === "s") {
            keteranganRow.style.display = "none";
            fileUploadRow.style.display = "block";
        } else {
            keteranganRow.style.display = "none";
            fileUploadRow.style.display = "none";
        }
    }

    $(function(){
        $("#tgl_mulai").datepicker({
        autoclose: true,
        todayHighlight: true,
        format: "yyyy-mm-dd"
        });
        $("#tgl_selesai").datepicker({
            autoclose: true,
            todayHighlight: true,
            format: "yyyy-mm-dd"
         });
    });

    function sumHari(){
        var tgl_mulai = $('#tgl_mulai').val();
        var tgl_selesai = $('#tgl_selesai').val();

        if(tgl_mulai && tgl_selesai){
            var selisihHari = Math.floor((Date.parse(tgl_selesai) - Date.parse(tgl_mulai)) / (1000 * 60 * 60 * 24));

            $("#jml_hari").val(selisihHari + 1);
        }
    }

    $(document).ready(function() {
        $("#tgl_mulai, #tgl_selesai").change(sumHari);
    });
</script>

@endpush
