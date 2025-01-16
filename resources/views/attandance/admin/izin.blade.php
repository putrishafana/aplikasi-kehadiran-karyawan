@extends('layouts.admin.master')
@section('content')
<style>
    .img-account-profile {
        height: 3rem;
        width: 3rem;
        object-fit: cover;
    }
    .rounded-square {
    border-radius: 10px; /* Sesuaikan radius sesuai kebutuhan Anda */
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />

<div class="sticky-top">
    <div class="page-heading">
        <h3>Approval Izin</h3>
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
        <div class="row">
            <div class="col-12">
                <form action="/panel/approval" class="" method="GET">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <input type="text" id="nama" name="nama" class="form-control" placeholder="Search" value="{{ Request('nama') }}">
                            </div>
                        </div>
                    <div class="col-2">
                        <div class="form-group">
                            <button type="submit" class="btn btn-secondary"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </div>
                    </div>
                </form>

            </div>
        </div>
        <table class="table table-bordered mb-0">
            <thead>
                <tr style="text-align: center">
                    <th style="auto">No</th>
                    <th style="auto">Nama</th>
                    <th style="auto">Divisi</th>
                    <th style="auto">Tanggal Izin / Sakit</th>
                    <th>Lama Izin / Sakit</th>
                    <th style="auto">Status</th>
                    <th style="auto">Keterangan</th>
                    <th style="auto">Approval</th>
                    <th style="auto">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($izinsakit as $d)
                <tr style="text-align: center">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $d->nama }}</td>
                    <td>{{ $d->divisi }}</td>
                    <td>{{ date('d-m-Y', strtotime($d->tgl_mulai)) }} - {{ date('d-m-Y', strtotime($d->tgl_selesai)) }}</td>
                    <td>{{ $d->jml_hari }} Hari</td>
                    <td>{{ $d->status == "i" ? "Izin" : "Sakit" }}</td>
                    <td>
                        @if ($d->status == "i")
                        {{ $d->keterangan}}
                        @else
                        <a id="suratsakit" type="button" class="btn btn-sm btn-secondary suratsakit" data-path="{{ Storage::url($d->bukti_sakit) }}"><i class="fa-solid fa-envelopes-bulk"></i> Surat Sakit</a>
                        @endif

                    </td>
                    <td>
                        @if ($d->approve==1)
                            <span class="badge bg-success">Approve</span>
                        @elseif ($d->approve==2)
                            <span class="badge bg-danger">Rejected</span>
                        @else
                            <span class="badge bg-warning">Waiting</span>
                        @endif
                    </td>
                    <td style="text-align: center">
                        @if ($d->approve == 0)
                        <a href="" data-id="{{ $d->id }}" class="btn btn-sm btn-success btn-approve"><i class="fa-solid fa-pen-nib"></i></a>
                        @else
                        <a href="/panel/{{ $d->id }}/batal-approve" class="btn btn-sm btn-danger btn-cancel"><i class="fa-solid fa-square-xmark"></i></a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $izinsakit->links('vendor.pagination.bootstrap-5') }}
    </div>
  </div>

  {{-- Modal Approval --}}
<div class="modal fade" id="modal-approval" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Approval Izin / Sakit</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="/panel/approve" method="POST">
                @csrf
                <input type="hidden" id="id_approve_form" name="id_approve_form">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <select name="approve" id="approve" class="form-select">
                                <option value="1">Approve</option>
                                <option value="2">Reject</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <button class="btn btn-sm btn-primary w-100" type="submit"><i class="fa-solid fa-paper-plane"></i> Submit</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>

      </div>
    </div>
  </div>

  <div class="modal fade" id="modal-surat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Review Surat Sakit</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <img id="modal-image" class="img-fluid" src="" alt="Surat Sakit">
        </div>

      </div>
    </div>
  </div>
@endsection




@push('myscript')
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

<script>
    $(function(){
        $('.btn-approve').click(function(e){
            e.preventDefault();
            var id = $(this).data("id");
            $('#id_approve_form').val(id);
            $("#modal-approval").modal("show");
        });

        $("#from, #to").datepicker({
        autoclose: true,
        todayHighlight: true,
        format: "yyyy-mm-dd"
        });

        $('.suratsakit').click(function(e){
            e.preventDefault();
            var path = $(this).data("path");
            $('#modal-image').attr('src', path);
            $('#modal-surat').modal("show");
        });
    });

</script>

@endpush
