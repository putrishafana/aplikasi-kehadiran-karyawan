
@foreach ($att as $t)
@php
    $foto_in = Storage::url('upload/attandance/'.$t->pic_in);
    $foto_out = Storage::url('upload/attandance/'.$t->pic_out);

    $table = $t->clock_in > '09:00' ? 'table-danger' : 'table-success';
@endphp
<tr class="{{ $table }}">
    <td style="text-align: center">{{ $loop->iteration }}</td>
    <td style="text-align: center">{{ $t->nik }}</td>
    <td style="text-align: center">{{ $t->nama }}</td>
    <td style="text-align: center">{{ $t->divisi }}</td>
    <td style="text-align: center">{{ $t->clock_in }}</td>
    <td style="text-align: center">{!! $t->clock_out != null ? $t->clock_out : '<span class="badge bg-danger">Belum Absen</span>' !!}</td>
    <td style="text-align: center">
        <div class="fotocenter">
            <img src="{{ url($foto_in) }}" alt="" class="img-account-profile rounded-square">
        </div>
    </td>
    <td>
        <div class="fotocenter">
            @if ($t->clock_out != null)
            <img src="{{ url($foto_out) }}" alt="" class="img-account-profile rounded-square">
            @else
            <i class="fa-solid fa-arrow-rotate-right"></i>
            @endif
        </div>
    </td>
    <td style="text-align: center">
        <a href="" id="{{ $t->attandance_id }}" class="tampilMaps" style="color: rgb(4, 4, 75);"><i class="fa-solid fa-map-location-dot"></i></a>
    </td>
</tr>
@endforeach


<script>
    $(function(){
        $(".tampilMaps").click(function(e){
            e.preventDefault();
            var attandance_id = $(this).attr("id");
            $.ajax({
                type: 'POST',
                url: '/panel/show-maps',
                data: {
                    _token: "{{ csrf_token() }}",
                    attandance_id: attandance_id
                },
                cache: false,
                success: function(respond){
                    $('#mapsForm').html(respond);
                }
            });
            $('#modal-maps').modal("show");
        });

    });
</script>



