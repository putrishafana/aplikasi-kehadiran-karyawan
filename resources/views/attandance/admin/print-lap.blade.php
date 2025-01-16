<style>
    td {
        padding: 5px;
    }

    .img-account-profile {
        height: 9rem;
        width: 7rem;
        object-fit: cover;
    }

    .rounded-square {
        border-radius: 10px;
        /* Sesuaikan radius sesuai kebutuhan Anda */
    }

    .fotocenter {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .tabelrekap {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
    }

    .tabelrekap tr,
    .tabelrekap th {
        border: 1px solid black;
        padding: 7px;
        font-family: Arial, Helvetica, sans-serif;
        background-color: rgb(201, 197, 197);
    }

    .tabelrekap tr,
    .tabelrekap td {
        border: 1px solid black;
        padding: 7px;
        font-family: Arial, Helvetica, sans-serif;
        background-color: transparent;
        text-align: center;
    }

    .print-button {
        display: none;
    }

    @media print {
        .print-button {
            display: block;
        }
    }
</style>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Print Rekap Kehadiran</title>

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
        @page {
            size: A4
        }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="A4">

    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-10mm">

        <table style="width: 100%">
            <tr>
                <td style="width: 50px">
                    <img src="{{ asset('assets/img/msib-gits.png') }}" width="100%" alt="">
                </td>
                <td style="width: 50px; text-align:center; font-family: Arial">
                    <h2 style="margin-bottom: 0%">Laporan Kehadiran Peserta Magang Bersertifikat PT Gits Indonesia</h2>
                    <i><span style="font-size: 10px; font-family: Arial;">Summarecon Bandung, Jl. Magna Timur No. 106.
                            Rancabolang, Kota Bandung 40296</span></i>
                </td>
            </tr>
        </table>
        <table style="margin-top: 30px">
            <tr>
            <tr>
                <td rowspan="5">
                    @php
                        $path = Storage::url('upload/karyawan/' . $karyawan->foto);
                    @endphp
                    <img src="{{ url($path) }}" class="img-account-profile rounded-square">
                </td>
            </tr>
            </tr>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{ $karyawan->nama }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>:</td>
                <td>{{ $karyawan->email }}</td>
            </tr>
            <tr>
                <td>Divisi</td>
                <td>:</td>
                <td>{{ $karyawan->divisi }}</td>
            </tr>
            <tr>
                <td>Periode</td>
                <td>:</td>
                <td>{{ ucfirst($name_month[$month]) }} {{ $year }}</td>
            </tr>
        </table>

        <table class="tabelrekap">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
                <th>Keterangan</th>
            </tr>
            @foreach ($att as $t)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ date('d-m-Y', strtotime($t->tanggal)) }}</td>
                    <td>{{ $t->clock_in }}</td>
                    <td>{{ $t->clock_out }}</td>
                    <td>
                        @if ($t->clock_in > '09:00')
                            Terlambat
                        @else
                            Hadir Tepat Waktu
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>

    </section>

</body>

</html>
<script>
    window.onload = function() {
        window.print(); // Memunculkan dialog pencetakan saat halaman dimuat
    };
</script>
