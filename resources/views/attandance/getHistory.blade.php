@if ($history->isEmpty())
    <div class="alert text-bold" style="background-color: #6bc8a3; color: white">
        <p>Data Kehadiran Belum Tersedia</p>
    </div>
@endif

@foreach ($history as $h)
<ul class="listview image-listview">
    <li>
        <div class="item">
            @php
                $path = Storage::url('upload/attandance/'.$h->pic_in)
            @endphp
            <img src="{{ url($path) }}" alt="image" class="image">
            <div class="in">
                <div>
                    <b>{{ date("d-m-Y", strtotime($h->tanggal)) }}</b>
                </div>
                <span class="badge {{ $h->clock_in < "09:00" ? "bg-success" : "bg-warning" }}">{{ $h->clock_in }}</span>
                <span class="badge bg-danger {{ $h->clock_out }}">{{ $h->clock_out }}</span>
            </div>
        </div>
    </li>
</ul>

@endforeach
