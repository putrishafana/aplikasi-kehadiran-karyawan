@extends('layouts.app')
@section('header')
<div class="appHeader text-light" style="background-color: #445a79">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Izin atau Sakit</div>
    <div class="right"></div>
</div>
@endsection

@section('content')
<style>
    .scrollable-content {
        height: calc(100vh - 50px);
        overflow-y: auto;
}
</style>

<div class="scrollable-content">
<div class="row" style="margin-top: 4rem">
    <div class="col mb-2">
        @php
            $msuccess = Session::get("success");
            $merror = Session::get("error");
            @endphp
            @if(Session::get("success"))
                <div class="alert alert-success">
                {{ $msuccess }}
                </div>
            @endif

            @if(Session::get("error"))
                <div class="alert alert-danger">
                {{ $merror }}
                </div>
            @endif
    </div>
</div>

<div class="row">
    <div class="col">
    @foreach ($dataizin as $d)
    <ul class="listview image-listview">
        <li>
            <div class="item">
                <div class="in">
                    <div>
                        <b>{{ date("d-m-Y", strtotime($d->tgl_mulai)) }} - {{ date("d-m-Y", strtotime($d->tgl_selesai)) }} ({{ $d->status == "s" ? "Sakit" : "Izin" }})</b><br>
                        @if ($d->status === 'i')
                        <small class="text-muted">Keterangan : {{ $d->keterangan }}</small><br>
                        @else
                        <small class="text-muted">Keterangan : Sakit</small><br>
                        @endif
                        <small class="text-muted">Lama Izin / Sakit : {{ $d->jml_hari }} Hari</small> <br>

                        @if ($d->approve == 0)
                        <form action="/attandance/{{ $d->id }}/batalkanPengajuan" method="POST">
                            @csrf
                            <button class="btn btn-danger btn-sm mt-1 batal"><ion-icon name="backspace-outline"></ion-icon> Batalkan Pengajuan</button>
                        </form>
                        @endif
                    </div>
                    @if ($d->approve == 0)
                        <span class="badge bg-warning">Waiting</span>
                        @elseif ($d->approve == 1)
                        <span class="badge bg-success">Approve</span>
                        @elseif ($d->approve == 2)
                        <span class="badge bg-danger">Rejected</span>
                    @endif
                </div>
            </div>
        </li>
    </ul>
    @endforeach
    </div>

</div>

<div class="fab-button bottom-right" style="margin-bottom: 60px">
    <a href="/attandance/createIzin" class="fab" style="background-color: #445a79"><ion-icon name="add-circle-outline"></ion-icon></a>
</div>
</div>
@endsection

@push('myscript')
<script>
    $(function(){
        $('.batal').click(function(e){
            var form = $(this).closest("form");
            e.preventDefault();
            Swal.fire({
            icon: 'question',
            title: "Apakah Anda yakin ingin membatalkan pengajuan ini?",
            showCancelButton: true,
            confirmButtonText: "Yes",
            }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
                Swal.fire("Pengajuan Berhasil Dibatalkan", "", "success");
            }
            });
        });
    });

</script>

@endpush
