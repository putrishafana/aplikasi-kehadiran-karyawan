@extends('layouts.app')

@section('header')
    <div class="appHeader text-light" style="background-color: #445a79">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">E-Attandance</div>
        <div class="right"></div>
    </div>

    <style>
        .camera,
        .camera video {
            display: inline-block;
            width: 100% !important;
            margin: auto;
            height: auto !important;
            border-radius: 15px;
        }

        #map {
            height: 210px;
        }

        .scrollable-content {
            height: calc(100vh - 50px);
            /* Adjust height as needed */
            overflow-y: auto;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
@endsection

@section('content')
    <div class="scrollable-content">

        <div class="row" style="margin-top: 70px">
            <div class="col">
                <select id="metode" class="form-control">
                    <option value="">Pilih Metode Kerja</option>
                    <option value="WFO">WFO</option>
                    <option value="WFH" data-lat="" data-lng="">WFH</option>
                </select>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col">
                <input type="hidden" id="loc">
                <div class="camera"></div>

            </div>

        </div>

        <div class="row">
            <div class="col">
                <div id="map"></div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col">
                @if ($check > 0)
                    <button id="clock_in" class="btn btn-danger btn-block"><ion-icon name="time-outline"></ion-icon> Clock
                        Out</button>
                @else
                    <button id="clock_in" class="btn btn-primary btn-block"><ion-icon name="time-outline"></ion-icon> Clock
                        In</button>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        $(document).ready(function() {
            var selectedMetode = "{{ $metode }}";
            if (selectedMetode) {
                $("#metode").val(selectedMetode);
            }
        });

        $(document).ready(function() {
            var check = "{{ $check }}";

            if (check > 0) {
                $('#metode').prop('disabled', true);
            }
        });

        Webcam.set({
            height: 480,
            width: 640,
            image_format: 'jpg',
            jpg_quality: 80
        });

        Webcam.attach('.camera');

        var loc = document.getElementById('loc');
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        }

        function successCallback(position) {
            loc.value = position.coords.latitude + "," + position.coords.longitude;

            var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 18);
            var loc_kntr = "{{ $location->location }}";
            var lokasi = loc_kntr.split(",");
            var latitude = lokasi[0];
            var longtitude = lokasi[1];
            var radius = "{{ $location->radius }}";

            googleStreets = L.tileLayer('http://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            }).addTo(map);

            var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);

            var circle = L.circle([latitude, longtitude], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: radius
            }).addTo(map);
        }

        function errorCallback() {

        }

        $("#clock_in").click(function(e) {
            var loc = $("#loc").val();
            var metode = $("#metode").val();
            if (!metode) {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Silakan Pilih Metode Kerja Terlebih Dahulu',
                    icon: 'warning'
                });
                return;
            }

            Webcam.snap(function(uri) {
                image = uri;
            });

            $.ajax({
                type: "POST",
                url: "/attandance/store",
                data: {
                    _token: "{{ csrf_token() }}",
                    image: image,
                    loc: loc,
                    metode: metode
                },
                cache: false,
                success: function(respond) {
                    var status = respond.split("|")

                    if (status[0] == "Success") {
                        Swal.fire({
                            title: 'Success!',
                            text: status[1],
                            icon: 'success',
                        })
                        setTimeout("location.href='/dashboard'", 3000);
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: status[1],
                            icon: 'error',
                        });
                    }
                }
            });

        });
    </script>
@endpush
