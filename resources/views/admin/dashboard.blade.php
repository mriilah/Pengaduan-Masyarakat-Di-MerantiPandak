<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 w-full">
            <!-- Sisi Kiri: Judul dan Current Time -->
            <div class="flex flex-col gap-2">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Dashboard</h2>
                    <p class="text-xs text-gray-500 mt-1">Kelurahan Meranti Pandak, Pekanbaru</p>
                </div>
                <div class="flex items-center gap-2 text-xs text-gray-500 font-semibold">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z"/></svg>
                    {{ now()->locale('id')->translatedFormat('l, d F Y') }}
                </div>
            </div>
            
            <!-- Sisi Kanan: Rentang Waktu dan Tombol Export PDF -->
            <div class="flex items-center w-full md:w-auto justify-start md:justify-end">
                <form action="{{ route('admin.dashboard.exportPdf') }}" method="GET" class="flex items-center gap-2 flex-nowrap w-full sm:w-auto justify-start">
                    <select name="bulan" class="block h-9 rounded-lg border-gray-200 bg-white text-xs font-semibold text-gray-700 py-1.5 focus:border-gray-900 focus:ring-gray-900 cursor-pointer w-28">
                        @foreach([
                            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
                            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
                            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                        ] as $val => $label)
                            <option value="{{ $val }}" {{ date('m') == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <select name="tahun" class="block h-9 rounded-lg border-gray-200 bg-white text-xs font-semibold text-gray-700 py-1.5 focus:border-gray-900 focus:ring-gray-900 cursor-pointer w-20">
                        @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                            <option value="{{ $y }}" {{ date('Y') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                    <button type="submit"
                        class="inline-flex items-center justify-center px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold rounded-md shadow-sm transition duration-150 gap-2 whitespace-nowrap">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export PDF
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- ===== STATISTIK CARDS ===== --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                {{-- Total --}}
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 hover:border-gray-300 transition-all">
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-gray-50 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Total</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalPengaduan }}</p>
                        </div>
                    </div>
                </div>

                {{-- Diajukan --}}
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 hover:border-amber-300 transition-all">
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-amber-50 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Diajukan</p>
                            <p class="text-2xl font-bold text-amber-600 mt-1">{{ $diajukan }}</p>
                        </div>
                    </div>
                </div>

                {{-- Diproses --}}
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 hover:border-blue-300 transition-all">
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Diproses</p>
                            <p class="text-2xl font-bold text-blue-600 mt-1">{{ $diproses }}</p>
                        </div>
                    </div>
                </div>

                {{-- Selesai --}}
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 hover:border-green-300 transition-all">
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Selesai</p>
                            <p class="text-2xl font-bold text-green-600 mt-1">{{ $selesai }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ===== PROGRESS BAR ===== --}}
            @if($totalPengaduan > 0)
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-semibold text-gray-900">Tingkat Penyelesaian Pengaduan</p>
                    <p class="text-sm font-bold text-green-600">{{ round(($selesai / $totalPengaduan) * 100, 1) }}%</p>
                </div>
                <div class="w-full bg-gray-100 h-2 flex rounded-full overflow-hidden">
                    @if($selesai > 0)
                    <div class="bg-green-500 h-2 transition-all" style="width: {{ ($selesai / $totalPengaduan) * 100 }}%"></div>
                    @endif
                    @if($diproses > 0)
                    <div class="bg-blue-500 h-2 transition-all" style="width: {{ ($diproses / $totalPengaduan) * 100 }}%"></div>
                    @endif
                    @if($diajukan > 0)
                    <div class="bg-amber-500 h-2 transition-all" style="width: {{ ($diajukan / $totalPengaduan) * 100 }}%"></div>
                    @endif
                </div>
                <div class="flex items-center gap-6 mt-4 text-xs text-gray-500 font-semibold">
                    <span class="flex items-center gap-2"><span class="w-3 h-3 bg-green-500 rounded-full"></span> Selesai</span>
                    <span class="flex items-center gap-2"><span class="w-3 h-3 bg-blue-500 rounded-full"></span> Diproses</span>
                    <span class="flex items-center gap-2"><span class="w-3 h-3 bg-amber-500 rounded-full"></span> Diajukan</span>
                </div>
            </div>
            @endif

            {{-- ===== PETA + SIDEBAR ===== --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Peta GIS --}}
                <div class="lg:col-span-2 bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden flex flex-col justify-between">
                    <div class="p-5 border-b border-gray-100">
                        <h3 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Peta Pengaduan Wilayah Kelurahan
                        </h3>
                    </div>
                    <div id="map" class="w-full h-[450px] z-0"></div>
                    <div class="px-5 py-4 border-t border-gray-100 flex flex-wrap gap-6 text-xs text-gray-500 font-semibold bg-gray-50">
                        <span class="flex items-center gap-2"><span class="w-3 h-3 bg-amber-500 rounded-full"></span> Diajukan</span>
                        <span class="flex items-center gap-2"><span class="w-3 h-3 bg-blue-500 rounded-full"></span> Diproses</span>
                        <span class="flex items-center gap-2"><span class="w-3 h-3 bg-green-500 rounded-full"></span> Selesai</span>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="space-y-6">

                    {{-- Per Kategori --}}
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
                        <div class="p-5 border-b border-gray-100">
                            <h3 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                Distribusi Kategori
                            </h3>
                        </div>
                        <div class="p-5 space-y-4">
                            @forelse($perKategori as $kat)
                            <div class="flex items-center justify-between py-1 border-b border-gray-100 last:border-0 pb-2 last:pb-0">
                                <span class="text-sm text-gray-600 font-medium truncate mr-2">{{ $kat->nama }}</span>
                                <span class="flex-shrink-0 inline-flex items-center justify-center px-2.5 py-1 text-xs font-semibold bg-gray-100 rounded-full text-gray-700">
                                    {{ $kat->pengaduans_count }} Laporan
                                </span>
                            </div>
                            @empty
                            <p class="text-sm text-gray-400 text-center py-2">Belum ada kategori</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- Pengaduan Terbaru --}}
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
                        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                            <h3 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Pengaduan Terbaru
                            </h3>
                            <a href="{{ route('admin.pengaduan.index') }}" class="text-xs text-gray-500 hover:text-gray-900 font-bold transition-colors">Lihat Semua →</a>
                        </div>
                        <div class="divide-y divide-gray-100">
                            @forelse($recentPengaduans as $p)
                            <a href="{{ route('admin.pengaduan.show', $p) }}" class="block p-4 hover:bg-gray-50 transition-colors">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="min-w-0">
                                        <p class="text-sm font-bold text-gray-900 truncate">{{ Str::limit($p->judul, 30) }}</p>
                                        <p class="text-xs text-gray-500 mt-1 font-medium">{{ $p->user->name ?? '-' }} · {{ $p->created_at->diffForHumans() }}</p>
                                    </div>
                                    <span class="flex-shrink-0 inline-flex px-2 py-0.5 text-[10px] font-semibold rounded-full @if($p->status === 'selesai') bg-green-100 text-green-700 @elseif($p->status === 'diproses') bg-blue-100 text-blue-700 @else bg-amber-100 text-amber-700 @endif">
                                        {{ $p->status_label }}
                                    </span>
                                </div>
                            </a>
                            @empty
                            <div class="p-6 text-center">
                                <p class="text-sm text-gray-400">Belum ada pengaduan</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="{{ asset('js/meranti-pandak-boundary.js') }}"></script>
    <script>
        const map = L.map('map', {
            scrollWheelZoom: false,
            zoomControl: true
        }).setView([0.5500, 101.4456], 15);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/">CARTO</a>'
        }).addTo(map);

        // Batas wilayah Kelurahan Meranti Pandak
        const boundary = L.polygon(MERANTI_PANDAK_BOUNDARY, {
            color: '#111111',
            weight: 2,
            opacity: 0.5,
            fillColor: '#111111',
            fillOpacity: 0.03,
            dashArray: '6, 4'
        }).addTo(map);
        map.fitBounds(boundary.getBounds().pad(0.05));

        function getColor(status) {
            return status === 'selesai' ? '#059669' : (status === 'diproses' ? '#2563EB' : '#D97706');
        }

        function makeIcon(color) {
            return L.divIcon({
                className: '',
                html: `<div style="background:${color};width:14px;height:14px;border-radius:50%;border:2px solid #FFFFFF;box-shadow:0 1px 3px rgba(0,0,0,0.3);"></div>`,
                iconSize: [14, 14],
                iconAnchor: [7, 7]
            });
        }

        const pengaduans = @json($pengaduans);
        const markers = [];

        pengaduans.forEach(function(p) {
            if (!p.latitude || !p.longitude) return;
            const c = getColor(p.status);
            const m = L.marker([parseFloat(p.latitude), parseFloat(p.longitude)], { icon: makeIcon(c) })
                .addTo(map)
                .bindPopup(`
                    <div style="min-width:180px;font-family:Inter,sans-serif;">
                        <div style="font-weight:700;font-size:12px;margin-bottom:4px;color:#111111;">${p.judul}</div>
                        <div style="font-size:11px;color:#6B7280;margin-bottom:6px;">
                            ${p.kategori ? p.kategori.nama : '-'} · ${p.user ? p.user.name : '-'}
                        </div>
                        <div>
                            <span style="display:inline-block;padding:2px 8px;font-size:10px;font-weight:600;color:#FFFFFF;background:${c};border-radius:10px;">
                                ${p.status}
                            </span>
                        </div>
                        <a href="/admin/pengaduan/${p.id}" style="display:inline-block;margin-top:8px;font-size:11px;color:#111111;font-weight:700;">LIHAT DETAIL →</a>
                    </div>
                `);
            markers.push(m);
        });

        if (markers.length > 0) {
            map.fitBounds(L.featureGroup(markers).getBounds().pad(0.15));
        }
    </script>
    @endpush
</x-app-layout>
