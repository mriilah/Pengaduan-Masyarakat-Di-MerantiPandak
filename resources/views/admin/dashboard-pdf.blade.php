<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Rekapitulasi Pengaduan Masyarakat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            color: #333;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 8px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 14pt;
            margin: 0;
            text-transform: uppercase;
        }
        .header h2 {
            font-size: 16pt;
            margin: 0;
            text-transform: uppercase;
        }
        .header p {
            font-size: 9pt;
            margin: 4px 0 0 0;
            font-style: italic;
        }
        .title {
            text-align: center;
            font-weight: bold;
            font-size: 12pt;
            text-transform: uppercase;
            margin-bottom: 20px;
        }
        .stats-table, .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .stats-table th, .stats-table td, .data-table th, .data-table td {
            border: 1px solid #666;
            padding: 8px;
            text-align: left;
        }
        .stats-table th, .data-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            font-size: 10pt;
            text-transform: uppercase;
        }
        .data-table td {
            font-size: 9pt;
        }
        .badge {
            padding: 2px 6px;
            font-size: 8pt;
            font-weight: bold;
            border-radius: 4px;
            text-transform: uppercase;
        }
        .badge-diajukan {
            background-color: #fef3c7;
            color: #92400e;
        }
        .badge-diproses {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .badge-selesai {
            background-color: #ecfdf5;
            color: #059669;
        }
        .footer-sig {
            margin-top: 40px;
            float: right;
            width: 250px;
            text-align: center;
        }
        .footer-sig p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Pemerintah Kota Pekanbaru</h1>
        <h2>Kelurahan Meranti Pandak</h2>
        <p>Alamat: Jl. Yos Sudarso No. 12 Pekanbaru, Kode Pos 28266</p>
    </div>

    <div class="title">
        Laporan Rekapitulasi Pengaduan Masyarakat<br>
        Bidang Infrastruktur dan Fasilitas Umum<br>
        <span style="font-size: 10pt; font-weight: normal; margin-top: 5px; display: block;">PERIODE: {{ $periode }}</span>
    </div>

    <h3>A. Statistik Pengaduan</h3>
    <table class="stats-table">
        <thead>
            <tr>
                <th>Total Pengaduan</th>
                <th>Status Diajukan</th>
                <th>Status Diproses</th>
                <th>Status Selesai</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $totalPengaduan }} Laporan</td>
                <td>{{ $diajukan }} Laporan</td>
                <td>{{ $diproses }} Laporan</td>
                <td>{{ $selesai }} Laporan</td>
            </tr>
        </tbody>
    </table>

    <h3>B. Sebaran Distribusi Kategori</h3>
    <table class="stats-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Jumlah Laporan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($perKategori as $index => $kat)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $kat->nama }}</td>
                <td>{{ $kat->pengaduans_count }} Laporan</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="page-break-before: always;"></div>

    <h3>C. Rincian Laporan Pengaduan</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 30%;">Judul Laporan</th>
                <th style="width: 20%;">Pelapor</th>
                <th style="width: 20%;">Kategori</th>
                <th style="width: 13%;">Status</th>
                <th style="width: 12%;">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengaduans as $index => $p)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $p->judul }}</td>
                <td>{{ $p->user->name ?? '-' }}</td>
                <td>{{ $p->kategori->nama ?? '-' }}</td>
                <td style="text-align: center;">
                    <span class="badge badge-{{ $p->status }}">{{ $p->status }}</span>
                </td>
                <td style="text-align: center;">{{ $p->created_at->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Belum ada data pengaduan masuk.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer-sig">
        <p>Pekanbaru, {{ now()->translatedFormat('d F Y') }}</p>
        <p style="margin-bottom: 60px;">Lurah Meranti Pandak</p>
        <p><strong>( _______________________ )</strong></p>
        <p>NIP. ........................................</p>
    </div>
</body>
</html>
