@extends('layouts.admin.master')
@section('content')
    <style>
        .img-account-profile {
            height: 3rem;
            width: 3rem;
        }

        .rounded-circle {
            border-radius: 50% !important;
        }

        .rounded-circle-v {
            border-radius: 50% !important;
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
    <div class="sticky-top">
        <div class="page-heading">
            <h3>Data Karyawan</h3>
        </div>
    </div>


    <div class="card">
        <div class="card-body px-4 py-4-5">
            <div class="row">
                <div class="col-12">
                    @if (Session::get('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif

                    @if (Session::get('warning'))
                        <div class="alert alert-warning">
                            {{ Session::get('warning') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-12">
                <a id="tambah-karyawan" class="btn btn-primary my-2"><i class="fa-regular fa-square-plus"></i> Tambah
                    Data</a>
            </div>
            <div class="table-responsive">
                <div class="row">
                    <div class="col-12">
                        <form action="/panel/listkaryawan" class="" method="GET">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <input type="text" id="nama" name="nama" class="form-control"
                                            placeholder="Search by Nama Karyawan" value="{{ Request('nama') }}">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <fieldset class="form-group">
                                        <select class="form-select" id="id_divisi" name="kd_divisi">
                                            <option value="">Select Divisi</option>
                                            @foreach ($divisi as $d)
                                                <option {{ Request('kd_divisi') == $d->kd_divisi ? 'selected' : '' }}
                                                    value="{{ $d->kd_divisi }}">{{ $d->nm_divisi }}</option>
                                            @endforeach
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-secondary"><i
                                                class="fa-solid fa-magnifying-glass"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

                <table class="table table-bordered mb-0">
                    <thead>
                        <tr style="text-align: center">
                            <th class="col">No</th>
                            <th class="col">Foto</th>
                            <th class="col-sm-2">Nama</th>
                            <th class="col-sm-2">Email</th>
                            <th>No Telepon</th>
                            <th>Divisi</th>
                            <th>Lokasi Tugas</th>
                            <th class="col-sm-1">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($karyawan as $k)
                            @php
                                $path = Storage::url('upload/karyawan/' . $k->foto);
                            @endphp

                            <tr>
                                <td>{{ $loop->iteration + $karyawan->firstitem() - 1 }}</td>
                                <td>
                                    @if (empty($k->foto))
                                        <img class="img-account-profile rounded-circle"
                                            src="{{ asset('assets/img/pp.png') }}" alt="avatar">
                                    @else
                                        <img class="img-account-profile rounded-circle" src="{{ url($path) }}"
                                            alt="avatar">
                                    @endif
                                </td>
                                <td><a class="view" href="#" nik="{{ $k->nik }}"
                                        style="color: rgb(38, 151, 196)">{{ $k->nama }}</a></td>
                                <td>{{ $k->email }}</td>
                                <td>{{ $k->no_telp }}</td>
                                <td>{{ $k->divisi }}</td>
                                <td>{{ $k->nama_loc }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-success btn-sm edit mx-1" nik="{{ $k->nik }}"
                                            href="#"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <form action="/panel/{{ $k->nik }}/delete" method="POST">
                                            @csrf
                                            <button class="btn btn-danger btn-sm delete" data-name="{{ $k->nama }}"><i
                                                    class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $karyawan->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>

    <div class="modal fade" id="modal-input" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data Karyawan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/panel/simpan-karyawan" method="POST" id="addKaryawan" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-code-branch"></i></span>
                                <input id="nik" name="nik" type="text" class="form-control" placeholder="NIK"
                                    required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-regular fa-face-smile"></i></span>
                                <input id="nama" name="nama" type="text" class="form-control"
                                    placeholder="Nama Lengkap" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-at"></i></span>
                                <input id="email" name="email" type="text" class="form-control"
                                    placeholder="Email" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-square-phone"></i></span>
                                <input id="no_telp" name="no_telp" type="text" class="form-control"
                                    placeholder="Nomor Telepon" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-people-group"></i></span>
                                <select onchange="getDivisi()" class="form-select" id="iddivisi" name="kd_divisi">
                                    <option value="">Select Divisi</option>
                                    @foreach ($divisi as $d)
                                        <option value="{{ $d->kd_divisi }}" data-nama="{{ $d->nm_divisi }}">
                                            {{ $d->kd_divisi }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-id-card"></i></span>
                                <input id="divisi_input" name="divisi" type="text" class="form-control"
                                    placeholder="Divisi" readonly>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-people-group"></i></span>
                                <select class="form-select" id="loc_tugas" name="loc_tugas">
                                    <option value="">Lokasi Tugas</option>
                                    @foreach ($loc_tugas as $l)
                                        <option value="{{ $l->id }}">{{ $l->nama_loc }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-image"></i></span>
                                <input id="foto" name="foto" class="form-control" type="file"
                                    id="formFile">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-circle-plus"></i> Tambah
                            Data</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Update Data Karyawan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="updateForm">

                </div>

            </div>
        </div>
    </div>


    {{-- Modal View --}}
    <div class="modal fade" id="modal-view" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Data Karyawan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="viewForm">

                </div>

            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        $(function() {
            $('#tambah-karyawan').click(function() {
                $('#modal-input').modal("show");
            });

            $('.edit').click(function() {
                var nik = $(this).attr('nik');
                $.ajax({
                    type: "POST",
                    url: '/panel/update-karyawan',
                    cache: false,
                    data: {
                        _token: "{{ csrf_token() }}",
                        nik: nik
                    },
                    success: function(respond) {
                        $('#updateForm').html(respond);
                    }
                });
                $('#modal-edit').modal("show");
            });

            $('.view').click(function() {
                var nik = $(this).attr('nik');
                $.ajax({
                    type: "POST",
                    url: '/panel/view-karyawan',
                    cache: false,
                    data: {
                        _token: "{{ csrf_token() }}",
                        nik: nik
                    },
                    success: function(respond) {
                        $('#viewForm').html(respond);
                    }
                });
                $('#modal-view').modal("show");
            });

            $('.delete').click(function(e) {
                var form = $(this).closest("form");
                var namaKar = $(this).data('name');
                e.preventDefault();
                Swal.fire({
                    title: "Apa Anda Yakin Akan Menghapus " + "'" + namaKar + "'" + "?",
                    showCancelButton: true,
                    confirmButtonText: "Yes",
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        form.submit();
                        Swal.fire("Terhapus", "", "success");
                    }
                });
            });


        });

        function getDivisi() {
            var get_id = document.getElementById("iddivisi");
            var get_divisi = document.getElementById("divisi_input");

            var selectedOption = get_id.options[get_id.selectedIndex];
            console.log(selectedOption); // Log the selected option object
            var selectedNama = selectedOption.dataset.nama;

            get_divisi.value = selectedNama;
        }

        function getDivisiUpdate() {
            var get_id = document.getElementById("id_divisi_update");
            var get_divisi = document.getElementById("divisi_input_update");

            var selectedOption = get_id.options[get_id.selectedIndex];
            console.log(selectedOption); // Log the selected option object
            var selectedNama = selectedOption.dataset.nama;

            get_divisi.value = selectedNama;
        }
    </script>
@endpush
