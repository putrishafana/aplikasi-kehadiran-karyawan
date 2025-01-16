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

    .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
<div class="sticky-top">
    <div class="page-heading">
        <h3>Administrator</h3>
    </div>
</div>


<div class="card">
    <div class="card-body px-4 py-4-5">
        <div class="row">
            <div class="col-12">
                <div class="alert">
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
        </div>
        <div class="col-12">
            <a id="tambah-admin" class="btn btn-primary my-2"><i class="fa-regular fa-square-plus"></i> Tambah Data</a>
        </div>
<div class="table-responsive">
    <div class="row">
        <div class="col-12">
            <form action="/panel/admin" class="" method="GET">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" id="name" name="name" class="form-control" placeholder="Search by Nama" value="{{ Request('name') }}">
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
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Status</th>
                <th>Reset Password</th>
                <th>Hapus Akun</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($admin as $k)

            <tr>
                <td style="text-align: center">{{ $loop->iteration + $admin->firstitem() -1 }}</td>
                <td>{{ $k->name }}</td>
                <td>{{ $k->email }}</td>
                <td style="text-align: center">
                    <label class="switch">
                        <input id="status" name="status" class="status-toggle" type="checkbox" data-id="{{ $k->id }}" {{ $k->status == "Aktif"  ? 'checked' : ' '  }}>
                        <span class="slider round"></span>
                      </label>
                </td>
                <td style="text-align: center">
                    <a href="" type="button" class="btn btn-warning btn-sm reset-password" data-id="{{ $k->id }}" data-email="{{ $k->email }}"><i class="fa-solid fa-key"></i> Reset Passsword</a>
                </td>
                <td style="text-align: center">
                    <form action="/panel/{{ $k->id }}/delete-akun" method="POST">
                        @csrf
                        <button class="btn btn-danger btn-sm delete" data-name="{{ $k->name }}"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $admin->links('vendor.pagination.bootstrap-5') }}
    </div></div>

    <div class="modal fade" id="modal-input" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah User</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="/panel/simpan-user" method="POST" id="addUser" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-regular fa-face-smile"></i></span>
                        <input id="name" name="name" type="text" class="form-control" placeholder="Nama Lengkap" required>
                      </div>
                </div>
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-at"></i></span>
                        <input id="email" name="email" type="text" class="form-control" placeholder="Email" required>
                      </div>
                </div>
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                        <input id="no_telp" name="no_telp" type="text" class="form-control" placeholder="Nomor Telepon" required>
                      </div>
                </div>
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-image"></i></span>
                            <input id="profil" name="profil" class="form-control" type="file" id="formFile">
                    </div>
                </div>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-circle-plus"></i> Tambah Data</button>
              </form>
            </div>

          </div>
        </div>
      </div>

@endsection

@push('myscript')
<script>
$(function(){
    $('#tambah-admin').click(function(){
        $('#modal-input').modal("show");
    });

    $('.delete').click(function(e){
            var form = $(this).closest("form");
            var nama = $(this).data('name');
            e.preventDefault();
            Swal.fire({
            title: "Apa Anda Yakin Akan Menghapus User " +"'"+nama+"'"+ "?",
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

$(document).ready(function() {
    $(document).on('change', '.status-toggle', function() {
        var userId = $(this).data('id');
        var status = $(this).prop('checked') ? 'Aktif' : 'Nonaktif';

        var originalStatus = $(this).prop('checked');
        var toggled = false;


        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin mengubah status pengguna ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/toggle-status',
                    method: 'POST',
                    data: {
                        id: userId,
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $(".alert").removeClass("alert-warning").addClass("alert-success").text("Status Akun Berhasil Diubah").show();
                    },
                    error: function(xhr) {
                        $(".alert").removeClass("alert-success").addClass("alert-warning").text("Status Akun Gagal Diubah").show();
                    }
                });
            } else {
                if (!toggled) {
                    $(this).prop('checked', originalStatus);
                }
            }
        });
    });
});

$(document).ready(function() {
    $(document).on('click', '.reset-password', function(e) {
        e.preventDefault();

        var userId = $(this).data('id');
        var userEmail = $(this).data('email');

        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda Yakin Akan Reset Password Menjadi ' + userEmail + '?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/reset-password',
                    method: 'POST',
                    data: {
                        id: userId,
                        email: userEmail,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $(".alert").removeClass("alert-warning").addClass("alert-success").text("Password Akun Berhasil di Ubah").show();
                    },
                    error: function(xhr) {
                        $(".alert").removeClass("alert-success").addClass("alert-warning").text("Password Akun Gagal di Ubah").show();
                    }
                });
            }
        });
    });
});



</script>

@endpush
