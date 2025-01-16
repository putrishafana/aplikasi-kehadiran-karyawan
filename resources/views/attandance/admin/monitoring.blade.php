@extends('layouts.admin.master')
@section('content')
    <style>
        .img-account-profile {
            height: 3rem;
            width: 3rem;
            object-fit: cover;
        }

        .rounded-square {
            border-radius: 10px;
            /* Sesuaikan radius sesuai kebutuhan Anda */
        }

        .fotocenter {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        body {
            font-size: 12px;
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet"
        type="text/css" />

    <div class="sticky-top">
        <div class="page-heading">
            <h3>Monitoring Kehadiran</h3>
        </div>
    </div>


    <div class="card">
        <div class="card-body px-4 py-4-5">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <div class="col-4">
                            <input type="text" class="form-control" id="tanggal" name="tanggal"
                                placeholder="Tanggal Kehadiran" autocomplete="off">
                        </div>
                    </div>

                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>

                                <th style="text-align: center">No</th>
                                <th style="text-align: center">NIK</th>
                                <th style="text-align: center">Nama</th>
                                <th style="text-align: center">Divisi</th>
                                <th style="text-align: center">Jam Masuk</th>
                                <th style="text-align: center">Jam Pulang</th>
                                <th style="text-align: center">Foto Masuk</th>
                                <th style="text-align: center">Foto Pulang</th>
                                <th style="text-align: center">Maps</th>
                            </tr>
                        </thead>
                        <tbody id="loadData">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {{-- Modal Maps --}}
    <div class="modal fade" id="modal-maps" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Lokasi Kehadiran</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="mapsForm">

                </div>

            </div>
        </div>
    </div>
@endsection




@push('myscript')
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
    <script>
        $(function() {
            $("#tanggal").datepicker({
                autoclose: true,
                todayHighlight: true,
                format: "yyyy-mm-dd"
            });
            loadData();

            function loadData() {
                var tanggal = $('#tanggal').val();
                $.ajax({
                    type: 'POST',
                    url: '/panel/get-data',
                    data: {
                        _token: "{{ csrf_token() }}",
                        tanggal: tanggal
                    },
                    cache: false,
                    success: function(respond) {
                        $("#loadData").html(respond);
                    }
                });
            }
            $("#tanggal").change(function(e) {
                loadData();
            });

        });
    </script>
@endpush
