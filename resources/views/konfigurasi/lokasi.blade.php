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
    <h3>Lokasi</h3>
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
            <a id="tambah-lokasi" class="btn btn-primary my-2"><i class="fa-regular fa-square-plus"></i> Tambah Data</a>
        </div>
<div class="table-responsive">
    <div class="row">
        <div class="col-12">
            <form action="/panel/config-loc" class="" method="GET">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" id="nama_loc" name="nama_loc" class="form-control" placeholder="Search" value="{{ Request('nama_loc') }}">
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
                <th style="auto">Nama Lokasi</th>
                <th style="auto">Koordinat</th>
                <th style="auto">Alamat</th>
                <th style="auto">Radius</th>
                <th style="auto">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lokasi as $d)
            <tr>
                <td>{{ $loop->iteration + $lokasi->firstitem() -1 }}</td>
                <td>{{ $d->nama_loc }}</td>
                <td>{{ $d->location }}</td>
                <td>{{ $d->alamat }}</td>
                <td>{{ $d->radius }}</td>
                <td style="text-align: center">
                    <div class="btn-group">
                        <a class="btn btn-success btn-sm edit mx-1" id="{{ $d->id }}" href="#"><i class="fa-solid fa-pen-to-square"></i></a>
                        <form action="/panel/{{ $d->id }}/delete-loc" method="POST">
                        @csrf
                        <button class="btn btn-danger btn-sm delete" data-name="{{ $d->nama_loc }}"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $lokasi->links('vendor.pagination.bootstrap-5') }}
    </div></div>

    <div class="modal fade" id="modal-input" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Lokasi</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="/panel/simpan-loc" method="POST" id="addLokasi" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-face-smile"></i></span>
                        <input id="nama_loc" name="nama_loc" type="text" class="form-control" placeholder="Nama Lokasi" required>
                      </div>
                </div>
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-location-dot"></i></span>
                        <input id="location" name="location" type="text" class="form-control" placeholder="Titik Koordinat" required>
                      </div>
                </div>
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-map-location-dot"></i></span>
                        <input id="alamat" name="alamat" type="text" class="form-control" placeholder="Alamat" required>
                      </div>
                </div>
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-circle-dot"></i></span>
                        <input id="radius" name="radius" type="text" class="form-control" placeholder="Radius" required>
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
          <h1 class="modal-title fs-5" id="exampleModalLabel">Update Lokasi</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="updateForm">

        </div>

      </div>
    </div>
  </div>

@endsection

@push('myscript')
<script>
    $(function(){
        $('#tambah-lokasi').click(function(){
            $('#modal-input').modal("show");
        });

        $('.edit').click(function(){
            var id = $(this).attr('id');
            $.ajax({
                type: "POST",
                url: '/panel/update-loc',
                cache: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success:function(respond){
                    $('#updateForm').html(respond);
                }
            });
            $('#modal-edit').modal("show");
        });


    });
        $('.delete').click(function(e){
            var form = $(this).closest("form");
            var namaLoc = $(this).data('name');
            e.preventDefault();
            Swal.fire({
            title: "Apa Anda Yakin Akan Menghapus " +"'"+namaLoc+"'"+ "?",
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

</script>

@endpush
