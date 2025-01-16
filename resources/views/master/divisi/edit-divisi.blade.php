<form action="/panel/{{ $divisi->kd_divisi }}/update-div" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <div class="input-group">
            <span class="input-group-text"><i class="fa-solid fa-code-branch"></i></span>
            <input id="kd_divisi" name="kd_divisi" type="text" class="form-control" placeholder="Kode Divisi" value="{{ $divisi->kd_divisi }}" disabled>
          </div>
    </div>
    <div class="mb-3">
        <div class="input-group">
            <span class="input-group-text"><i class="fa-regular fa-face-smile"></i></span>
            <input id="nm_divisi" name="nm_divisi" type="text" class="form-control" placeholder="Nama Divisi" value="{{ $divisi->nm_divisi }}" required>
          </div>
    </div>
    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-arrows-rotate"></i> Update Data</button>
</form>
