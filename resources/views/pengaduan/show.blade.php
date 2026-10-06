<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-900 leading-tight">
                {{ __('Detail Pengaduan') }}
            </h2>
            <a href="{{ route('pengaduan.index') }}" class="text-gray-500 hover:text-gray-700 font-medium text-sm transition-colors">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-6 sm:p-8">
                    <!-- Status Badge -->
                    <div class="flex items-center justify-between mb-6 border-b border-gray-100 pb-6">
                        <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full @if($pengaduan->status === 'selesai') bg-green-100 text-green-700 @elseif($pengaduan->status === 'diproses') bg-blue-100 text-blue-700 @else bg-amber-100 text-amber-700 @endif">
                            {{ $pengaduan->status_label }}
                        </span>
                        <span class="text-xs text-gray-400">{{ $pengaduan->created_at->format('d M Y, H:i') }}</span>
                    </div>

                    <!-- Judul -->
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $pengaduan->judul }}</h3>

                    <!-- Kategori -->
                    <div class="mb-6">
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 text-xs font-medium rounded-full">{{ $pengaduan->kategori->nama }}</span>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-6">
                        <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Deskripsi</h4>
                        <p class="text-gray-700 whitespace-pre-line text-sm leading-relaxed">{{ $pengaduan->deskripsi }}</p>
                    </div>

                    <!-- Foto -->
                    @if($pengaduan->foto)
                        <div class="mb-6">
                            <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Foto Bukti</h4>
                            <img src="{{ asset('storage/' . $pengaduan->foto) }}" alt="Foto pengaduan" class="max-w-full max-h-96 rounded-lg border border-gray-200" />
                        </div>
                    @endif

                    <!-- Peta Lokasi -->
                    <div class="mb-6">
                        <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Lokasi Pemetaan</h4>
                        <div id="map" class="w-full h-72 rounded-lg border border-gray-200 z-0"></div>
                        <p class="mt-3 text-xs text-gray-400">
                            Koordinat: <span class="text-gray-700 font-medium">{{ $pengaduan->latitude }}, {{ $pengaduan->longitude }}</span>
                        </p>
                    </div>

                    <!-- Aksi -->
                    @if($pengaduan->status === 'diajukan')
                        <div class="flex space-x-3 pt-6 border-t border-gray-100">
                            <a href="{{ route('pengaduan.edit', $pengaduan) }}" class="inline-flex items-center px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition">
                                Edit Pengaduan
                            </a>
                            <form action="{{ route('pengaduan.destroy', $pengaduan) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengaduan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const map = L.map('map', {
            scrollWheelZoom: false,
            zoomControl: true
        }).setView([{{ $pengaduan->latitude }}, {{ $pengaduan->longitude }}], 15);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/">CARTO</a>'
        }).addTo(map);

        const statusColors = { 'selesai': '#059669', 'diproses': '#2563EB', 'diajukan': '#D97706' };
        const markerColor = statusColors['{{ $pengaduan->status }}'] || '#D97706';

        const customIcon = L.divIcon({
            className: '',
            html: `<div style="background:${markerColor};width:16px;height:16px;border-radius:50%;border:2px solid #FFF;box-shadow:0 1px 4px rgba(0,0,0,0.3);"></div>`,
            iconSize: [16, 16],
            iconAnchor: [8, 8]
        });

        L.marker([{{ $pengaduan->latitude }}, {{ $pengaduan->longitude }}], { icon: customIcon })
            .addTo(map)
            .bindPopup('<strong style="color:#111;">{{ $pengaduan->judul }}</strong>')
            .openPopup();
    </script>
    @endpush
</x-app-layout>
