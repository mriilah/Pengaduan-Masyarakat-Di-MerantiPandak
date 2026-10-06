<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-900 leading-tight">
            {{ __('Edit Pengaduan') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-6 sm:p-8">
                    <form action="{{ route('pengaduan.update', $pengaduan) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Judul -->
                        <div class="mb-6">
                            <x-input-label for="judul" :value="__('Judul Pengaduan')" />
                            <x-text-input id="judul" name="judul" type="text" class="mt-2 block w-full" :value="old('judul', $pengaduan->judul)" required autofocus />
                            <x-input-error :messages="$errors->get('judul')" class="mt-2" />
                        </div>

                        <!-- Kategori -->
                        <div class="mb-6">
                            <x-input-label for="kategori_id" :value="__('Kategori')" />
                            <select id="kategori_id" name="kategori_id" class="mt-2 block w-full border-gray-200 bg-white text-gray-900 rounded-lg focus:border-gray-900 focus:ring-gray-900 text-sm shadow-sm" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ old('kategori_id', $pengaduan->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('kategori_id')" class="mt-2" />
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-6">
                            <x-input-label for="deskripsi" :value="__('Deskripsi')" />
                            <textarea id="deskripsi" name="deskripsi" rows="5" class="mt-2 block w-full border-gray-200 bg-white text-gray-900 rounded-lg focus:border-gray-900 focus:ring-gray-900 text-sm shadow-sm" required>{{ old('deskripsi', $pengaduan->deskripsi) }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                        </div>

                        <!-- Foto -->
                        <div class="mb-6">
                            <x-input-label for="foto" :value="__('Foto Bukti (kosongkan jika tidak ingin mengubah)')" />
                            @if($pengaduan->foto)
                                <div class="mt-3 mb-3">
                                    <p class="text-xs text-gray-400 mb-2">Foto saat ini:</p>
                                    <img src="{{ asset('storage/' . $pengaduan->foto) }}" alt="Foto saat ini" class="max-h-32 rounded-lg border border-gray-200" />
                                </div>
                            @endif
                            <input id="foto" name="foto" type="file" accept="image/*" class="mt-2 block w-full text-sm text-gray-500 file:mr-4" />
                            <x-input-error :messages="$errors->get('foto')" class="mt-2" />
                        </div>

                        <!-- Peta Lokasi -->
                        <div class="mb-6">
                            <x-input-label :value="__('Lokasi Pengaduan (Klik pada peta untuk mengubah)')" />
                            <div id="map" class="mt-2 w-full h-96 rounded-lg border border-gray-200 z-0"></div>
                            <x-input-error :messages="$errors->get('latitude')" class="mt-2" />

                            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $pengaduan->latitude) }}">
                            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $pengaduan->longitude) }}">

                            <div class="mt-3 flex space-x-6 text-sm text-gray-500">
                                <span>Lat: <strong id="lat-display" class="text-gray-900">{{ old('latitude', $pengaduan->latitude) }}</strong></span>
                                <span>Lng: <strong id="lng-display" class="text-gray-900">{{ old('longitude', $pengaduan->longitude) }}</strong></span>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="flex items-center justify-end mt-8 border-t border-gray-100 pt-6">
                            <a href="{{ route('pengaduan.show', $pengaduan) }}" class="text-gray-500 hover:text-gray-700 mr-6 font-medium text-sm transition-colors">Batal</a>
                            <x-primary-button>
                                {{ __('Perbarui Pengaduan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="{{ asset('js/meranti-pandak-boundary.js') }}"></script>
    <script>
        const lat = {{ old('latitude', $pengaduan->latitude) }};
        const lng = {{ old('longitude', $pengaduan->longitude) }};

        const map = L.map('map').setView([lat, lng], 15);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/">CARTO</a>'
        }).addTo(map);

        // Tampilkan polygon batas wilayah Kelurahan Meranti Pandak
        const boundaryPolygon = L.polygon(MERANTI_PANDAK_BOUNDARY, {
            color: '#111111',
            weight: 2,
            opacity: 0.5,
            fillColor: '#111111',
            fillOpacity: 0.03,
            dashArray: '6, 4'
        }).addTo(map);

        // Fungsi validasi apakah titik berada di dalam batas wilayah
        function isInsideBoundary(lat, lng) {
            const poly = MERANTI_PANDAK_BOUNDARY;
            let inside = false;
            for (let i = 0, j = poly.length - 1; i < poly.length; j = i++) {
                const xi = poly[i][0], yi = poly[i][1];
                const xj = poly[j][0], yj = poly[j][1];
                const intersect = ((yi > lng) !== (yj > lng)) &&
                    (lat < (xj - xi) * (lng - yi) / (yj - yi) + xi);
                if (intersect) inside = !inside;
            }
            return inside;
        }

        const customIcon = L.divIcon({
            className: '',
            html: '<div style="background:#111;width:16px;height:16px;border-radius:50%;border:2px solid #FFF;box-shadow:0 1px 4px rgba(0,0,0,0.3);"></div>',
            iconSize: [16, 16],
            iconAnchor: [8, 8]
        });

        let marker = L.marker([lat, lng], { icon: customIcon }).addTo(map);

        map.on('click', function(e) {
            // Cek apakah lokasi yang diklik berada di dalam batas wilayah
            if (!isInsideBoundary(e.latlng.lat, e.latlng.lng)) {
                const popup = L.popup()
                    .setLatLng(e.latlng)
                    .setContent('<div style="color:#DC2626;font-weight:600;font-size:12px;">⚠️ Lokasi di luar wilayah Kel. Meranti Pandak</div>')
                    .openOn(map);
                setTimeout(() => map.closePopup(popup), 2000);
                return;
            }

            const newLat = e.latlng.lat.toFixed(7);
            const newLng = e.latlng.lng.toFixed(7);

            document.getElementById('latitude').value = newLat;
            document.getElementById('longitude').value = newLng;
            document.getElementById('lat-display').textContent = newLat;
            document.getElementById('lng-display').textContent = newLng;

            marker.setLatLng(e.latlng);
        });
    </script>
    @endpush
</x-app-layout>
