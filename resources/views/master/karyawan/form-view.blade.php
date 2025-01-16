
<form action="#" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="avatar fotocenter m-2">
        @if (!empty($karyawan->foto))
        @php
            $path = Storage::url("upload/karyawan/".$karyawan->foto);
        @endphp
        <img src="{{ url($path) }}" alt="avatar" class="rounded-circle-v" style="width: 150px; height:150px">
        @else
        <img src="{{ asset('assets/img/pp.png') }}" alt="avatar" class="rounded-circle-v" style="width: 150px; height:150px">
        @endif
    </div>
    <div class="mb-3">
        <div class="input-group">
            <span class="input-group-text"><i class="fa-solid fa-code-branch"></i></span>
            <input id="nik" name="nik" type="text" class="form-control" placeholder="NIK" value="{{ $karyawan->nik }}" readonly>
          </div>
    </div>
    <div class="mb-3">
        <div class="input-group">
            <span class="input-group-text"><i class="fa-regular fa-face-smile"></i></span>
            <input id="nama" name="nama" type="text" class="form-control" placeholder="Nama Lengkap" value="{{ $karyawan->nama }}" required>
          </div>
    </div>
    <div class="mb-3">
        <div class="input-group">
            <span class="input-group-text"><i class="fa-solid fa-at"></i></span>
            <input id="email" name="email" type="text" class="form-control" placeholder="Email" value="{{ $karyawan->email }}" required>
          </div>
    </div>
    <div class="mb-3">
        <div class="input-group">
            <span class="input-group-text"><i class="fa-solid fa-square-phone"></i></span>
            <input id="no_telp" name="no_telp" type="text" class="form-control" placeholder="Nomor Telepon" value="{{ $karyawan->no_telp }}" required>
          </div>
    </div>
    <div class="mb-3">
        <div class="input-group">
            <span class="input-group-text"><i class="fa-solid fa-people-group"></i></span>
            <select onchange="getDivisiUpdate()" class="form-select" id="id_divisi_update" name="kd_divisi">
                <option value="">Select Divisi</option>
                @foreach ($divisi as $d)
                    <option {{ $karyawan->kd_divisi == $d->kd_divisi ? 'selected' : '' }} value="{{ $d->kd_divisi }}" data-nama="{{ $d->nm_divisi }}">{{ $d->kd_divisi }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="mb-3">
        <div class="input-group">
            <span class="input-group-text"><i class="fa-solid fa-id-card"></i></span>
            <input id="divisi_input_update" name="divisi" type="text" class="form-control" placeholder="Divisi" value="{{ $karyawan->divisi }}" readonly>
        </div>
    </div>
  </form>


