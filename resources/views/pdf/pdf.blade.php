<html>
<head>
  <style>
    @page {
      size: A4;
      margin: 2cm 2cm 2cm 2cm;
    }
    body {
        font-family: Arial;
      }
      .tabledata {
        border-collapse: collapse;
        border: none;
        /* width: 100%; */
        padding: 5px;
      }
      td, th {
        padding: 8px;
        text-align: left;
      }
      .header {
        text-align: center;
        font-weight: bold;
        network error
        font-size: 20px;
        }
        .header-img {
        width: 110%;
        height: auto;
        margin-top: -1.5cm;
        display: block;
        }
      
      .report-content {
          padding: 20px 0;
          padding-left: 10px;
          text-align: justify;
          text-justify: inter-word;
          
          
      }
      .report-content .isi {
        text-indent: 4em;
      }
      .img-container {
      text-align: center;
      margin-top: 20px;
      }
      .img-content {
      width: auto;
      height: auto;
      display: inline-block;
      margin: 0 10px;
      }
      .qr-code {
          display: inline-block;
          width: 30%;
          text-align: center;
          margin-bottom: 20px;
          page-break-inside: avoid;
      }
      .qr-code-container {
                display: flex;
                flex-wrap: wrap;
            }
  </style>

  </head>
  <body>
    <!-- KOP Surat -->
    <div class="header">
      <img class="header-img" src="{{ asset('img/KOP2.jpg') }}" alt="KOP Image">
    </div>
    <br>
    <!-- Tabel Informasi -->
    <table class="tabledata">
      <!-- Nomor Surat Tugas -->
      <tr>
        <td>Nomor Surat Tugas</td>
        <td>:</td>
        <td>{{ $report->no_st }}</td>
      </tr>

      <!-- Judul Kegiatan -->
      <tr>
        <td>Judul Kegiatan</td>
        <td>:</td>
        <td>{{ $report->what }}</td>
      </tr>
      <!-- Nama Pembuat Laporan -->
      <tr>
        <td>Nama Pembuat Laporan</td>
        <td>:</td>
        <td>{{ $report->user->name }}
          @foreach ($report->pengikutreport as $item)
           @if ($loop->last)
              &
           @endif
           @if(!$loop->last)
              ,
            @endif
          {{ $item->name }}
              
          @endforeach
        </td>
      </tr>
      <!-- Tanggal Mulai -->
      <tr>
        <td>Tanggal Mulai</td>
        <td>:</td>
        <td>{{ date('d-m-Y', strtotime($report->when ))}}</td>
      </tr>
      <!-- Tanggal Selesai -->
      <tr>
        <td>Tanggal Selesai</td>
        <td>:</td>
        <td>{{ date('d-m-Y', strtotime($report->tanggal_selesai ))}}</td>
      </tr>
      <!-- Tempat -->
      <tr>
        <td>Tempat</td>
        <td>:</td>
        <td>{{ $report->where }}</td>
      </tr>
      <!-- IKU -->
      <tr>
        <td>IKU</td>
        <td>:</td>
        <td>@foreach ($report->indicator as $iku)
            @if (!$loop->first && $loop->last)
              &
            @endif
            @if(!$loop->last)
                ,
              @endif
            {{ $iku->nama }} (IKU : {{ $iku->nomor }})
        @endforeach</td>
      </tr>
      <!-- Pihak Yang Terlibat -->
      <tr>
        <td>Pihak Yang Terlibat</td>
        <td>:</td>
        <td>{{ $report->who }}</td>
      </tr>
      <!-- Jumlah Perempuan Yang Hadir -->
      <tr>
        <td>Persentase Perempuan Yang Hadir</td>
        <td>:</td>
        <td>{{ $report->gender_wanita }}%</td>
      </tr>
    </table>
    <!-- Deskripsi Kegiatan -->
    <div class="report-content">
      <p>Deskripsi Kegiatan</p>
     
        {!! $report->how !!}

    </div>
<!-- Dokumentasi Gambar 1 -->
      <div style="margin: 20px 0; text-align: center;">
       
       <img src="{{ asset('dokumentasi/'.$report->dokumentasi->dokumentasi1) }}" style="width: 50%; height: auto; border: 1px solid #ccc;">
        {{-- <p style="margin-top: 10px;">Gambar 1: Judul Gambar 1</p> --}}
      </div>

      <!-- Dokumentasi Gambar 2 -->
      @if ($report->dokumentasi->dokumentasi2 != null)
        
      <div style="margin: 20px 0; text-align: center;">
        <img src="{{ asset('dokumentasi/'.$report->dokumentasi->dokumentasi2) }}" style="width: 50%; height: auto; border: 1px solid #ccc;">
        {{-- <p style="margin-top: 10px;">Gambar 2: Judul Gambar 2</p> --}}
      </div>
      @endif

      <!-- Dokumentasi Gambar 3 -->
      @if ($report->dokumentasi->dokumentasi3 != null)
      <div style="margin: 20px 0; text-align: center;">
        <img src="{{ asset('dokumentasi/'.$report->dokumentasi->dokumentasi3) }}" style="width: 50%; height: auto; border: 1px solid #ccc;">
        {{-- <p style="margin-top: 10px;">Gambar 3: Judul Gambar 3</p> --}}
      </div>
      @endif

   
    <!-- QR Code -->
    <div class="qr-code-container">
      @if ($report->dokumentasi->st != null)
        <div class="qr-code">
          <p>Dokumentasi ST</p>
          <img src="data:image/png;base64, {!! $q_st !!} ">
        </div>
      @endif
     
      @if ($report->dokumentasi->st != null)
      <div class="qr-code">
        <p>Dokumentasi Lainnya</p>
        <img src="data:image/png;base64, {!! $q_lainnya !!} ">
      </div>
      @endif
      
      <div class="qr-code">
        <p>Cek Laporan Online</p>
        <img src="data:image/png;base64, {!! $q_report !!} ">
      </div>
    </div>
  </body>
</html>