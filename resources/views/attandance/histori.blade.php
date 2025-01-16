@extends('layouts.app')
@section('header')
<div class="appHeader text-light" style="background-color: #445a79">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">History</div>
    <div class="right"></div>
</div>
@endsection

@section('content')
<div class="row" style="margin-top: 4rem">
    <div class="col">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <select name="month" id="month" class="form-control">
                        <option value="">Bulan</option>
                        @for ($i=1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ date('m') == $i ? 'selected' : '' }}>{{ $bulan[$i] }}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <select name="year" id="year" class="form-control">
                        <option value="">Tahun</option>
                        @php
                            $tahun = 2020;
                            $thisYear = date('Y');
                        @endphp
                        @for ($t=$tahun; $t <= $thisYear; $t++)
                            <option value="{{ $t }}" {{ date('Y') == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <button id="getData" class="btn btn-block" style="background-color: #445a79; color: white; text-size: 30px">
                        <ion-icon name="search-circle-outline" style="color: white;"></ion-icon>
                        Search</button>
                    </select>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="row">
    <div class="col" id="show">

    </div>
</div>

@endsection

@push('myscript')

<script>
    $(function(){
        $("#getData").click(function(e){
            var month = $("#month").val();
            var year = $("#year").val();

            $.ajax({
                type: "POST",
                url: '/getHistory',
                data:{
                    _token: "{{ csrf_token() }}",
                    month: month,
                    year: year
                },
                cache:false,
                success: function(respond){
                    $("#show").html(respond);
                }
            });
        });
    })
</script>

@endpush
