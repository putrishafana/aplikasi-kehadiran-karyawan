@extends('layouts.app')
@section('header')

<div class="appHeader text-light" style="background-color: #445a79">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Edit Profile</div>
    <div class="right" style="margin-right: 5px">
        <a href="#" class="headerButton" onclick="confirmLogout()"><ion-icon name="log-out-outline"></ion-icon></a>
    </div>
</div>
@endsection

@section('content')

<style>
    .img-account-profile {
    height: 5.5rem;
    width: 5.5rem;
}
.rounded-circle {
    border-radius: 50% !important;
}
.scrollable-content {
        height: calc(100vh - 50px);
        overflow-y: auto;
}
</style>
<div class="scrollable-content">
<div class="row mb-1" style="margin-top: 4rem">
    <div class="col">
        @php
            $msuccess = Session::get("success");
            $merror = Session::get("error");
            @endphp
            @if(Session::get("success"))
                <div class="alert alert-success">
                {{ $msuccess }}
                </div>
            @endif

            @if(Session::get("error"))
                <div class="alert alert-danger">
                {{ $merror }}
                </div>
            @endif
    </div>
</div>
    <div class="avatar text-center">
        @if (!empty(Auth::guard('karyawan')->user()->foto))
        @php
            $path = Storage::url("upload/karyawan/".Auth::guard('karyawan')->user()->foto);
        @endphp
        <img src="{{ url($path) }}" alt="avatar" class="img-account-profile rounded-circle">
        @else
        <img src="assets/img/pp.png" alt="avatar" class="imaged w64 rounded">
        @endif
    </div>
<form action="/attandance/{{ $karyawan->nik }}/update" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="col">
        <div class="form-group boxed">
            <div class="input-wrapper">
                <input type="text" class="form-control" value="{{ $karyawan->nama }}" name="nama" placeholder="Nama Lengkap" autocomplete="off">
            </div>
        </div>
        <div class="form-group boxed">
            <div class="input-wrapper">
                <input type="text" class="form-control" value="{{ $karyawan->no_telp }}" name="no_telp" placeholder="Nomor Telepon" autocomplete="off">
            </div>
        </div>
        <div class="form-group boxed">
            <div class="input-wrapper">
                <input type="password" class="form-control" name="password" placeholder="Type New Password" autocomplete="off">
            </div>
        </div>
        <div class="custom-file-upload" id="fileUpload1">
            <input type="file" name="foto" id="fileuploadInput" accept=".png, .jpg, .jpeg">
            <label for="fileuploadInput">
                <span>
                    <strong>
                        <ion-icon name="cloud-upload-outline" role="img" class="md hydrated" aria-label="cloud upload outline"></ion-icon>
                        <i>Tap to Upload</i>
                    </strong>
                </span>
            </label>
        </div>
        <div class="form-group boxed">
            <div class="input-wrapper">
                <button type="submit" class="btn btn-block" style="background-color: #445a79; color: white">
                    <ion-icon style="color: white" name="refresh-outline"></ion-icon>
                    Update
                </button>
            </div>
        </div>
    </div>
</form>
</div>
@endsection

@push('myscript')
<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Apakah Anda Yakin Akan Melakukan Logout?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Logout',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/gologout';
            }
        });
    }
</script>

@endpush
