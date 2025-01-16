@extends('layouts.app')
@section('content')
    <style>
        .gradasigreenpastel {
            color: white;
            background-image: linear-gradient(to bottom right,
                    rgb(44, 45, 36, 1),
                    rgb(63, 65, 51, 1));
        }

        .gradasiredpastel {
            color: white;
            background-image: linear-gradient(to bottom right,
                    rgba(167, 51, 64, 1),
                    rgb(165, 65, 64, 1));
        }

        #section-user {
            height: 180px;
            background-color: #445a79;
            padding: 20px;
        }

        .img-account-profile {
            height: 4.5rem;
            width: 4.5rem;
        }

        .rounded-circle {
            border-radius: 50% !important;
        }
    </style>

    <div class="section" id="section-user">
        <div id="user-detail">
            <div class="avatar">
                @if (!empty(Auth::guard('karyawan')->user()->foto))
                    @php
                        $path = Storage::url('upload/karyawan/' . Auth::guard('karyawan')->user()->foto);
                    @endphp
                    <img src="{{ url($path) }}" alt="avatar" class="img-account-profile rounded-circle">
                @else
                    <img src="assets/img/pp.png" alt="avatar" class="imaged w64 rounded">
                @endif
            </div>
            <div id="user-info">
                <h2 id="user-name">{{ $getNama }}</h2>
                <span id="user-role">{{ $getDivisi }}</span>
            </div>
        </div>
    </div>

    <div class="section" id="presence-section">
        <div style="margin-top: 20px; margin-bottom: 20px">
            <div class="row">
                <div class="col-6">
                    <div class="card gradasigreenpastel">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    <ion-icon name="time-outline"></ion-icon>
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Clock In</h4>
                                    <span>{{ $attToday != null ? $attToday->clock_in : '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card gradasiredpastel">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    <ion-icon name="time-outline"></ion-icon>
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Clock Out</h4>
                                    <span>{{ $attToday != null && $attToday->clock_out != null ? $attToday->clock_out : '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div id="rekap">
            <h3>Rekap Kehadiran Bulan {{ $bulan[$thisMonth] }} {{ $thisYear }}</h3>
            <div class="row">
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 16px 12px !important">
                            <span class="badge badge-success"
                                style="position: absolute; top:10px ; right:5px; font-size:0.7rem">{{ $rekap->jmlHadir }}</span>
                            <ion-icon name="bag-check-outline" style="font-size: 1.5rem" class="text-success"></ion-icon>
                            <span style="font-size: 12px; font-weight:500">Hadir</span>
                        </div>
                    </div>
                </div>

                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 16px 12px !important">
                            <span class="badge badge-warning"
                                style="position: absolute; top:10px ; right:5px; font-size:0.7rem">{{ $rekapizin->jmlizin }}</span>
                            <ion-icon name="mail-open-outline" style="font-size: 1.5rem" class="text-warning"></ion-icon>
                            <br>
                            <span style="font-size: 12px; font-weight:500">Izin</span>
                        </div>
                    </div>
                </div>

                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 16px 12px !important">
                            <span class="badge badge-danger"
                                style="position: absolute; top:10px ; right:5px; font-size:0.7rem">{{ $rekapizin->jmlsakit }}</span>
                            <ion-icon name="medkit-outline" style="font-size: 1.5rem" class="text-danger"></ion-icon>
                            <span style="font-size: 12px; font-weight:500">Sakit</span>
                        </div>
                    </div>
                </div>

                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 16px 12px !important">
                            <span class="badge badge-secondary"
                                style="position: absolute; top:10px ; right:5px; font-size:0.7rem">{{ $rekap->jmlTelat }}</span>
                            <ion-icon name="timer-outline" style="font-size: 1.5rem" class="text-secondary"></ion-icon>
                            <span style="font-size: 12px; font-weight:500">Telat</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <h3 class="mt-3">History Kehadiran Bulan {{ $bulan[$thisMonth] }} {{ $thisYear }}</h3>
        <div class="tab-content mt-2" style="margin-bottom:100px;">
            <div class="tab-pane fade show active" id="home" role="tabpanel">
                @foreach ($historyMonth as $h)
                    <ul class="listview image-listview">
                        <li>
                            <div class="item">
                                <div class="icon-box" style="background-color: #445a79">
                                    <ion-icon style="color: white" name="calendar-clear-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    <div>{{ date('d-m-Y', strtotime($h->tanggal)) }}</div>
                                    <span class="badge badge-success">{{ $h->clock_in }}</span>
                                    <span class="badge badge-danger">{{ $h->clock_out }}</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                @endforeach
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel">
                <ul class="listview image-listview">
                    <li>
                        <div class="item">
                            <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                            <div class="in">
                                <div>Edward Lindgren</div>
                                <span class="text-muted">Designer</span>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item">
                            <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                            <div class="in">
                                <div>Emelda Scandroot</div>
                                <span class="badge badge-primary">3</span>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item">
                            <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                            <div class="in">
                                <div>Henry Bove</div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item">
                            <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                            <div class="in">
                                <div>Henry Bove</div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item">
                            <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                            <div class="in">
                                <div>Henry Bove</div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

        </div>
    </div>
    </div>
@endsection
