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
        font-size: 14px;
    }
</style>
<div class="page-heading">
    <h3>Data Divisi</h3>
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
            <a id="tambah-divisi" class="btn btn-primary my-2"><i class="fa-regular fa-square-plus"></i> Tambah Data</a>
        </div>
<div class="table-responsive">
    <div class="row">
        <div class="col-12">
            <form action="/panel/list-divisi" class="" method="GET">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" id="nm_divisi" name="nm_divisi" class="form-control" placeholder="Search" value="{{ Request('nm_divisi') }}">
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
                <th style="auto">Kode Divisi</th>
                <th style="auto">Nama Divisi</th>
                <th style="auto">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($divisi as $d)
            <tr>
                <td>{{ $loop->iteration + $divisi->firstitem() -1 }}</td>
                <td>{{ $d->kd_divisi }}</td>
                <td><a class="view" href="#" kd_divisi="{{ $d->kd_divisi }}" style="color: rgb(38, 151, 196)">{{ $d->nm_divisi }}</a></td>
                <td style="text-align: center">
                    <div class="btn-group">
                        <a class="btn btn-success btn-sm edit mx-1" kd_divisi="{{ $d->kd_divisi }}" href="#"><i class="fa-solid fa-pen-to-square"></i></a>
                        <form action="/panel/{{ $d->kd_divisi }}/delete-div" method="POST">
                        @csrf
                        <button class="btn btn-danger btn-sm delete" data-name="{{ $d->nm_divisi }}"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $divisi->links('vendor.pagination.bootstrap-5') }}
    </div></div>

    <div class="modal fade" id="modal-input" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data Divisi</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="/panel/simpan-divisi" method="POST" id="addDivisi" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-code-branch"></i></span>
                        <input id="kd_divisi" name="kd_divisi" type="text" class="form-control" placeholder="Kode Divisi" required>
                      </div>
                </div>
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-regular fa-face-smile"></i></span>
                        <input id="nm_divisi" name="nm_divisi" type="text" class="form-control" placeholder="Nama Divisi" required>
                      </div>
                </div>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-circle-plus"></i> Tambah Data</button>
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
          <h1 class="modal-title fs-5" id="exampleModalLabel">Update Data Divisi</h1>
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
    $(function(){
        $('#tambah-divisi').click(function(){
            $('#modal-input').modal("show");
        });

        $('.edit').click(function(){
            var kd_divisi = $(this).attr('kd_divisi');
            $.ajax({
                type: "POST",
                url: '/panel/update-divisi',
                cache: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    kd_divisi: kd_divisi
                },
                success:function(respond){
                    $('#updateForm').html(respond);
                }
            });
            $('#modal-edit').modal("show");
        });

        $('.view').click(function(){
            var kd_divisi = $(this).attr('kd_divisi');
            $.ajax({
                type: "POST",
                url: '/panel/view-divisi',
                cache: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    kd_divisi: kd_divisi
                },
                success:function(respond){
                    $('#viewForm').html(respond);
                }
            });
            $('#modal-view').modal("show");
        });

        $('.delete').click(function(e){
            var form = $(this).closest("form");
            var namaDiv = $(this).data('name');
            e.preventDefault();
            Swal.fire({
            title: "Apa Anda Yakin Akan Menghapus " +"'"+namaDiv+"'"+ "?",
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

</script>

@endpush
