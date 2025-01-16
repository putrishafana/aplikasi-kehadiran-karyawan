@extends('layouts.admin.master')

@section('content')
    <style>
        .img-account-profile {
            height: 5.5rem;
            width: 5.5rem;
        }

        .rounded-circle {
            border-radius: 50% !important;
        }
    </style>

    <div class="page-heading">
        <h3>Dashboard Administrator</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col">
                <div class="row mb-2">
                    <div class="col-12">
                        <div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="font-semibold mb-0" style="float: left" id="currentDate">{{ date('d F Y') }}</p>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <p class="font-semibold mb-0" id="currentTime">{{ date('H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body py-4 px-4">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-xl">
                                    @if (!empty(Auth::guard('user')->user()->profil))
                                        @php
                                            $path = Storage::url('upload/users/' . Auth::guard('user')->user()->profil);
                                        @endphp
                                        <img src="{{ url($path) }}" alt="avatar" class="text-center"
                                            style="height: 5.5rem; width: 5.5rem; border-radius: 50% !important;">
                                    @else
                                        <img src="{{ asset('assets/img/pp.png') }}" alt="avatar" class="text-center"
                                            style="height: 5.5rem; width: 5.5rem; border-radius: 50% !important;">
                                    @endif
                                </div>
                                <div class="ms-3 name">
                                    <h5 class="font-bold" style="font-size: 15px" data-bs-toggle="offcanvas"
                                        data-bs-target="#demo">{{ Auth::guard('user')->user()->name }}</h5>
                                    <h6 class="text-muted mb-0">Administrator</h6>
                                </div>
                                <div class="ms-auto">
                                    <a href="#" onclick="confirmLogout()" type="button"><i
                                            class="fa-solid fa-right-from-bracket"></i> Logout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-sm-4 col-sm-12 col-sm-12 col-sm-5 d-flex justify-content-start ">
                                        <div class="stats-icon mb-2" style="background-color: rgb(185, 97, 15)">
                                            <i class="fa-solid fa-people-group"></i>
                                        </div>
                                    </div>
                                    <div class="col-sm-8 col-sm-12 col-sm-12 col-sm-7">
                                        <h6 class="text-muted font-semibold">Jumlah Karyawan</h6>
                                        <h6 class="font-extrabold mb-0">{{ $jmlkaryawan != null ? $jmlkaryawan : 0 }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-sm-4 col-sm-12 col-sm-12 col-sm-5 d-flex justify-content-start ">
                                        <div class="stats-icon mb-2" style="background-color: rgb(20, 143, 201)">
                                            <i class="fa-solid fa-house-chimney-user"></i>
                                        </div>
                                    </div>
                                    <div class="col-sm-8 col-sm-12 col-sm-12 col-sm-7">
                                        <h6 class="text-muted font-semibold">Karyawan WFH</h6>
                                        <h6 class="font-extrabold mb-0">{{ $jmlwfh != null ? $jmlwfh : 0 }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-sm-4 col-sm-12 col-sm-12 col-sm-5 d-flex justify-content-start ">
                                        <div class="stats-icon blue mb-2">
                                            <i class="fa-solid fa-fingerprint"></i>
                                        </div>
                                    </div>
                                    <div class="col-sm-8 col-sm-12 col-sm-12 col-sm-7">
                                        <h6 class="text-muted font-semibold">Kehadiran</h6>
                                        <h6 class="font-extrabold mb-0">
                                            {{ $rekap->jmlHadir != null ? $rekap->jmlHadir : 0 }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-sm-4 col-sm-12 col-sm-12 col-sm-5 d-flex justify-content-start ">
                                        <div class="stats-icon mb-2" style="background-color: rgb(50, 112, 55)">
                                            <i class="fa-solid fa-file"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Izin</h6>
                                        <h6 class="font-extrabold mb-0">{{ $jmlizin != null ? $jmlizin : 0 }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon mb-2" style="background-color: rgb(209, 47, 47)">
                                            <i class="fa-brands fa-medrt"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Sakit</h6>
                                        <h6 class="font-extrabold mb-0">{{ $jmlsakit != null ? $jmlsakit : 0 }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon mb-2" style="background-color: rgb(235, 164, 13)">
                                            <i class="fa-solid fa-clock"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Terlambat</h6>
                                        <h6 class="font-extrabold mb-0">
                                            {{ $rekap->jmlTelat != null ? $rekap->jmlTelat : 0 }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="offcanvas offcanvas-end" id="demo">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title">User Info</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div class="row" style="margin-top: 4rem">
                        <div class="col">
                            @php
                                $msuccess = Session::get('success');
                                $merror = Session::get('error');
                            @endphp
                            @if ($msuccess)
                                <script>
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success!',
                                        text: '{{ $msuccess }}'
                                    });
                                </script>
                            @endif

                            @if ($merror)
                                <script>
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: '{{ $merror }}'
                                    });
                                </script>
                            @endif
                        </div>

                        <div class="avatar justify-content-center align-items-center mb-2" style="margin-right: 9rem">
                            @if (!empty(Auth::guard('user')->user()->profil))
                                @php
                                    $path = Storage::url('upload/users/' . Auth::guard('user')->user()->profil);
                                @endphp
                                <img src="{{ url($path) }}" alt="avatar" class="text-center"
                                    style="height: 5.5rem; width: 5.5rem; border-radius: 50% !important;">
                            @else
                                <img src="{{ asset('assets/img/pp.png') }}" alt="avatar" class="text-center"
                                    style="height: 5.5rem; width: 5.5rem; border-radius: 50% !important;">
                            @endif
                        </div>
                    </div>
                    <form action="/panel/{{ $user->id }}/update" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="col">
                            <div class="form-group boxed">
                                <div class="input-wrapper">
                                    <input type="text" class="form-control" value="{{ $user->name }}"
                                        name="name" placeholder="Nama Lengkap" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group boxed">
                                <div class="input-wrapper">
                                    <input type="text" class="form-control" value="{{ $user->no_telp }}"
                                        name="no_telp" placeholder="Nomor Telepon" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group boxed">
                                <div class="input-wrapper">
                                    <input type="text" class="form-control" value="{{ $user->email }}"
                                        name="email" placeholder="Email" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group boxed">
                                <div class="input-wrapper">
                                    <input type="password" class="form-control" name="password"
                                        placeholder="Type New Password" autocomplete="off">
                                </div>
                            </div>
                            <div class="custom-file-upload" id="fileUpload1">
                                <input type="file" name="profil" id="fileuploadInput" accept=".png, .jpg, .jpeg">
                                <label for="fileuploadInput">
                                    <span>
                                        <strong>
                                            <ion-icon name="cloud-upload-outline" role="img" class="md hydrated"
                                                aria-label="cloud upload outline"></ion-icon>
                                            <i>Tap to Upload Profil Photo</i>
                                        </strong>
                                    </span>
                                </label>
                            </div>
                            <div class="form-group boxed">
                                <div class="input-wrapper">
                                    <button type="submit" class="btn btn-block"
                                        style="background-color: #445a79; color: white">
                                        <ion-icon style="color: white" name="refresh-outline"></ion-icon>
                                        Update
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
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
                            window.location.href = '/logoutadmin';
                        }
                    });
                }

                function updateDateTime() {
                    var currentDateTime = new Date();
                    var currentDate = currentDateTime.toLocaleDateString('en-US', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric',
                        weekday: 'long'
                    });
                    var currentTime = currentDateTime.toLocaleTimeString();
                    document.getElementById('currentDate').innerText = currentDate;
                    document.getElementById('currentTime').innerText = currentTime;
                }

                updateDateTime();

                setInterval(updateDateTime, 1000);
            </script>
        @endpush
