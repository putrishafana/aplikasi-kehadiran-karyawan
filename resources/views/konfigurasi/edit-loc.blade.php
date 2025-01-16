<form action="/panel/{{ $lokasi->id }}/update-loc" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <div class="input-group">
            <span class="input-group-text"><i class="fa-solid fa-face-smile"></i></span>
            <input id="nama_loc" name="nama_loc" type="text" class="form-control" placeholder="Nama Lokasi" value="{{ $lokasi->nama_loc }}" required>
          </div>
    </div>
    <div class="mb-3">
        <div class="input-group">
            <span class="input-group-text"><i class="fa-solid fa-location-dot"></i></span>
            <input id="location" name="location" type="text" class="form-control" value="{{ $lokasi->location }}" placeholder="Titik Koordinat" required>
          </div>
    </div>
    <div class="mb-3">
        <div class="input-group">
            <span class="input-group-text"><i class="fa-solid fa-map-location-dot"></i></span>
            <input id="alamat" name="alamat" type="text" class="form-control" value="{{ $lokasi->alamat }}" placeholder="Alamat" required>
          </div>
    </div>
    <div class="mb-3">
        <div class="input-group">
            <span class="input-group-text"><i class="fa-solid fa-circle-dot"></i></span>
            <input id="radius" name="radius" type="text" class="form-control" value="{{ $lokasi->radius }}" placeholder="Radius" required>
          </div>
    </div>
    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-arrows-rotate"></i> Update Data</button>
</form>
