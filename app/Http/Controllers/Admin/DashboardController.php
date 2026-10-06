<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPengaduan = Pengaduan::count();
        $diajukan = Pengaduan::where('status', Pengaduan::STATUS_DIAJUKAN)->count();
        $diproses = Pengaduan::where('status', Pengaduan::STATUS_DIPROSES)->count();
        $selesai = Pengaduan::where('status', Pengaduan::STATUS_SELESAI)->count();

        $perKategori = Kategori::withCount('pengaduans')->get();

        // Data untuk peta GIS
        $pengaduans = Pengaduan::with('kategori', 'user')
            ->select('id', 'judul', 'status', 'latitude', 'longitude', 'kategori_id', 'user_id', 'created_at')
            ->get();

        // Pengaduan terbaru
        $recentPengaduans = Pengaduan::with('user', 'kategori')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPengaduan',
            'diajukan',
            'diproses',
            'selesai',
            'perKategori',
            'pengaduans',
            'recentPengaduans'
        ));
    }

    public function exportPdf(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        // Query filtered by month and year
        $query = Pengaduan::whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun);

        $totalPengaduan = (clone $query)->count();
        $diajukan = (clone $query)->where('status', Pengaduan::STATUS_DIAJUKAN)->count();
        $diproses = (clone $query)->where('status', Pengaduan::STATUS_DIPROSES)->count();
        $selesai = (clone $query)->where('status', Pengaduan::STATUS_SELESAI)->count();

        // Kategori counts filtered by month/year as well
        $perKategori = Kategori::withCount(['pengaduans' => function($q) use ($bulan, $tahun) {
            $q->whereMonth('created_at', $bulan)->whereYear('created_at', $tahun);
        }])->get();

        $pengaduans = Pengaduan::with('kategori', 'user')
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->latest()
            ->get();

        // Mapping month number to Indonesian name
        $bulanNames = [
            '01' => 'JANUARI', '02' => 'FEBRUARI', '03' => 'MARET',
            '04' => 'APRIL', '05' => 'MEI', '06' => 'JUNI',
            '07' => 'JULI', '08' => 'AGUSTUS', '09' => 'SEPTEMBER',
            '10' => 'OKTOBER', '11' => 'NOVEMBER', '12' => 'DESEMBER'
        ];
        $periode = $bulanNames[sprintf('%02d', $bulan)] . ' ' . $tahun;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.dashboard-pdf', compact(
            'totalPengaduan',
            'diajukan',
            'diproses',
            'selesai',
            'perKategori',
            'pengaduans',
            'periode'
        ));

        return $pdf->download('laporan-pengaduan-' . strtolower(str_replace(' ', '-', $periode)) . '.pdf');
    }
}
