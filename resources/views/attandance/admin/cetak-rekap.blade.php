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
    border-radius: 10px; /* Sesuaikan radius sesuai kebutuhan Anda */
    }

    .fotocenter {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .tabelrekap{
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
    }
    .tabelrekap tr,
    .tabelrekap th{
        border: 1px solid black;
        padding: 7px;
        font-family: Arial, Helvetica, sans-serif;
        background-color: rgb(201, 197, 197);
        font-size: 10px;
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
  <style>@page { size: A4 }</style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A4 landscape">

  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
  <section class="sheet padding-10mm">

    <table style="width: 100%">
    <tr>
        <td style="width: 50px">
            <img src="{{ asset('assets/img/msib-gits.png') }}" width="100%" alt="">
        </td>
        <td style="width: 50px; text-align:center; font-family: Arial">
            <h2 style="margin-bottom: 0%">Rekap Kehadiran Peserta Magang Bersertifikat PT Gits Indonesia Periode {{ ucfirst($name_month[$month]) }} {{ $year }}</h2>
            <i><span style="font-size: 10px; font-family: Arial;">Summarecon Bandung, Jl. Magna Timur No. 106. Rancabolang, Kota Bandung 40296</span></i>
        </td>
    </tr>
    </table>

    <table class="tabelrekap">
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Nama</th>
            <th colspan="31">Tanggal</th>
            <th rowspan="2">KH</th>
            <th rowspan="2">KT</th>
        </tr>
        <tr>
            @for ($i = 1; $i <= 31; $i++)
            <th>{{ $i }}</th>
            @endfor
        </tr>
        @foreach ($rekap as $r)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $r->nama }}</td>
        <?php
        $ttl = 0;
        $tk = 0;
        ?>
        @for ($i = 1; $i <= 31; $i++)
            <?php
            $tgl = "tanggal_".$i;
            if(empty($r->$tgl)){
                $hadir = [" ", " "];
                $ttl += 0;
            } else {
                $hadir = explode("-", $r->$tgl);
                $ttl += 1;
                if ($hadir[0] > "09:00:00") {
                    $tk += 1;
                }
            }
            ?>
            <td>
                <span style="color: {{ $hadir[0] > "09:00:00" ? "red" : "green" }}">{{ $hadir[0] }}</span> <br>
                <span style="color: {{ $hadir[1] <= "18:00:00" ? "red" : "green" }}">{{ $hadir[1] }}</span> <br>
            </td>
        @endfor
        <td>{{ $ttl }}</td>
        <td>{{ $tk }}</td>
    </tr>
@endforeach

    </table>
        <b><p style="font-size:10px;font-family: Arial, Helvetica, sans-serif">Keterangan:</p></b>
            <p style="font-size:10px;font-family: Arial, Helvetica, sans-serif">KH : Kehadiran</p>
            <p style="font-size:10px;font-family: Arial, Helvetica, sans-serif">KT : Keterlambatan</p>
</section>


</body>

</html>
<script>
    window.onload = function() {
      window.print(); // Memunculkan dialog pencetakan saat halaman dimuat
    };
  </script>
