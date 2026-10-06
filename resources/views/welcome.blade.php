<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengaduan Masyarakat — Kelurahan Meranti Pandak</title>
    <meta name="description" content="Platform pengaduan masyarakat berbasis GIS untuk menyampaikan keluhan, saran, dan aspirasi secara mudah dan transparan.">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin="" />

    <style>
        /* ===== RESET & BASE ===== */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #FFFFFF;
            color: #1a1a1a;
            line-height: 1.6;
            overflow-x: hidden;
        }
        a { text-decoration: none; color: inherit; }
        img { max-width: 100%; display: block; }

        /* ===== NAVBAR ===== */
        .navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1000;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid #F3F4F6;
            transition: all 0.3s;
        }
        .navbar.scrolled {
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .nav-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 700;
            font-size: 1rem;
            color: #111;
        }
        .nav-brand-icon {
            width: 32px; height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .nav-brand-icon img {
            width: 32px; height: 32px;
            object-fit: contain;
        }
        .nav-links { display: flex; gap: 1rem; align-items: center; }
        .nav-link-item {
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s;
            color: #6B7280;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
        }
        .nav-link-item:hover { color: #111; }
        .nav-link-item.btn-signup {
            background: #111;
            color: #FFF;
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            font-weight: 600;
        }
        .nav-link-item.btn-signup:hover {
            background: #333;
        }

        /* ===== HERO ===== */
        .hero {
            padding: 10rem 2rem 5rem;
            max-width: 720px;
            margin: 0 auto;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.35rem 0.85rem;
            background: #F3F4F6;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            color: #10B981;
            margin-bottom: 1.5rem;
        }
        .hero-badge .dot {
            width: 6px; height: 6px;
            background: #10B981;
            border-radius: 50%;
        }
        .hero h1 {
            font-size: clamp(2.25rem, 5vw, 3.5rem);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.25rem;
            color: #111;
            letter-spacing: -0.02em;
        }
        .hero-desc {
            font-size: 1.05rem;
            color: #6B7280;
            max-width: 480px;
            margin-bottom: 2rem;
            line-height: 1.7;
        }
        .hero-buttons {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        /* ===== BUTTONS ===== */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
            font-family: inherit;
            border-radius: 8px;
        }
        .btn-dark {
            background: #111;
            color: #FFF;
        }
        .btn-dark:hover {
            background: #333;
        }
        .btn-light {
            background: #FFF;
            color: #111;
            border: 1px solid #E5E7EB;
        }
        .btn-light:hover {
            border-color: #D1D5DB;
            background: #F9FAFB;
        }

        /* ===== SECTION COMMON ===== */
        .section {
            padding: 5rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .section-header {
            margin-bottom: 3rem;
        }
        .section-label {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 600;
            color: #10B981;
            margin-bottom: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .section-title {
            font-size: clamp(1.5rem, 3vw, 2.25rem);
            font-weight: 800;
            color: #111;
            margin-bottom: 0.75rem;
            letter-spacing: -0.02em;
        }
        .section-desc {
            color: #6B7280;
            font-size: 1rem;
            max-width: 500px;
            line-height: 1.7;
        }

        /* ===== FEATURES ===== */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.25rem;
        }
        .feature-card {
            background: #FFFFFF;
            border: 1px solid #E5E7EB;
            padding: 2rem 1.75rem;
            border-radius: 12px;
            transition: all 0.2s;
        }
        .feature-card:hover {
            border-color: #D1D5DB;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        }
        .feature-icon {
            width: 40px; height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 1.25rem;
        }
        .feature-icon.black { background: #111; }
        .feature-icon.gold { background: #B38600; }
        .feature-icon.gray { background: #6B7280; }
        .feature-card h3 {
            font-size: 1rem;
            font-weight: 700;
            color: #111;
            margin-bottom: 0.5rem;
        }
        .feature-card p {
            color: #6B7280;
            font-size: 0.875rem;
            line-height: 1.6;
        }

        /* ===== MAP SECTION ===== */
        .map-wrapper {
            border: 1px solid #E5E7EB;
            border-radius: 12px;
            overflow: hidden;
            background: #F9FAFB;
        }
        #map {
            width: 100%;
            height: 500px;
        }
        .map-overlay {
            position: absolute;
            top: 1rem;
            left: 1rem;
            z-index: 999;
            background: #FFF;
            border: 1px solid #E5E7EB;
            border-radius: 8px;
            padding: 1rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        }
        .map-overlay h4 {
            font-size: 0.8rem;
            font-weight: 700;
            color: #111;
            margin-bottom: 0.25rem;
        }
        .map-overlay p {
            font-size: 0.75rem;
            color: #6B7280;
        }

        /* ===== STATS ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.25rem;
        }
        .stat-card {
            text-align: center;
            padding: 2.5rem 1.5rem;
            background: #FFF;
            border: 1px solid #E5E7EB;
            border-radius: 12px;
            transition: all 0.2s;
        }
        .stat-card:hover {
            border-color: #D1D5DB;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        }
        .stat-icon {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: #111;
            line-height: 1;
            margin-bottom: 0.5rem;
        }
        .stat-label {
            font-size: 0.8rem;
            color: #6B7280;
            font-weight: 600;
        }

        /* ===== CTA (Subscribe-like) ===== */
        .cta-section {
            padding: 4rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .cta-card {
            max-width: 700px;
            margin: 0 auto;
            text-align: center;
            padding: 4rem 2rem;
        }
        .cta-card h2 {
            font-size: clamp(1.5rem, 3vw, 2rem);
            font-weight: 800;
            color: #111;
            margin-bottom: 0.75rem;
            letter-spacing: -0.02em;
        }
        .cta-card p {
            color: #6B7280;
            font-size: 1rem;
            margin-bottom: 2rem;
            line-height: 1.7;
        }
        .cta-buttons { display: flex; gap: 0.75rem; justify-content: center; flex-wrap: wrap; }

        /* ===== FOOTER ===== */
        .footer {
            padding: 2.5rem 2rem;
            border-top: 1px solid #F3F4F6;
            text-align: center;
        }
        .footer p {
            color: #9CA3AF;
            font-size: 0.8rem;
        }
        .footer-heart { color: #EF4444; }

        /* ===== BADGES (Status like mockup) ===== */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.2rem 0.6rem;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
        }
        .badge-green { background: #ECFDF5; color: #059669; border: 1px solid #A7F3D0; }
        .badge-red { background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; }
        .badge-gray { background: #F3F4F6; color: #6B7280; border: 1px solid #E5E7EB; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .navbar { padding: 0.75rem 1rem; }
            .hero { padding: 7rem 1.25rem 3rem; }
            .section { padding: 3.5rem 1.25rem; }
            .features-grid { grid-template-columns: 1fr; }
            #map { height: 350px; }
            .cta-card { padding: 2.5rem 1rem; }
            .stat-number { font-size: 2rem; }
        }

        /* ===== LEAFLET CUSTOM ===== */
        .leaflet-popup-content-wrapper {
            background: #FFF !important;
            color: #1a1a1a !important;
            border-radius: 10px !important;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1) !important;
            border: 1px solid #E5E7EB !important;
        }
        .leaflet-popup-tip { background: #FFF !important; }
        .leaflet-popup-content { font-family: 'Inter', sans-serif; font-size: 0.85rem; }
        .popup-title { font-weight: 700; margin-bottom: 4px; color: #111; }
        .popup-status {
            display: inline-block;
            padding: 2px 8px;
            font-size: 0.7rem;
            font-weight: 600;
            border-radius: 20px;
        }
        .popup-status.diajukan { background: #FEF3C7; color: #92400E; }
        .popup-status.diproses { background: #DBEAFE; color: #1E40AF; }
        .popup-status.selesai { background: #ECFDF5; color: #059669; }

        /* ===== SCROLL ANIMATIONS ===== */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>

    <!-- ===== NAVBAR ===== -->
    <nav class="navbar" id="navbar">
        <div class="nav-brand">
            <div class="nav-brand-icon">
                <img src="{{ asset('images/logo-sm.png') }}" alt="Logo Pengaduan" />
            </div>
            <span>Pengaduan Masyarakat</span>
        </div>
        <div class="nav-links">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="nav-link-item btn-signup">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="nav-link-item">Masuk</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="nav-link-item btn-signup">Daftar</a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <!-- ===== HERO ===== -->
    <section class="hero" id="hero">
        <div class="hero-badge">
            <span class="dot"></span>
            Kelurahan Meranti Pandak
        </div>
        <h1>Sampaikan aspirasi Anda dengan mudah.</h1>
        <p class="hero-desc">
            Platform pengaduan masyarakat berbasis GIS — setiap laporan dilengkapi pemetaan lokasi untuk penanganan yang lebih cepat dan tepat.
        </p>
        <div class="hero-buttons">
            @auth
                <a href="{{ route('pengaduan.create') }}" class="btn btn-dark">Buat Pengaduan</a>
            @else
                <a href="{{ route('register') }}" class="btn btn-dark">Mulai Sekarang</a>
            @endauth
            <a href="#map-section" class="btn btn-light">Lihat Peta</a>
        </div>
    </section>

    <!-- ===== FEATURES ===== -->
    <section class="section" id="features">
        <div class="section-header reveal">
            <span class="section-label">Fitur Unggulan</span>
            <h2 class="section-title">Mengapa menggunakan platform ini?</h2>
            <p class="section-desc">Dirancang untuk memudahkan masyarakat dalam menyampaikan pengaduan secara efisien.</p>
        </div>
        <div class="features-grid">
            <div class="feature-card reveal">
                <div class="feature-icon black">📝</div>
                <h3>Mudah Digunakan</h3>
                <p>Form pengaduan yang sederhana dan intuitif. Cukup isi detail, unggah foto, dan tandai lokasi.</p>
            </div>
            <div class="feature-card reveal">
                <div class="feature-icon gold">🗺️</div>
                <h3>Pemetaan Interaktif</h3>
                <p>Setiap pengaduan dilengkapi koordinat GPS dan ditampilkan di peta interaktif.</p>
            </div>
            <div class="feature-card reveal">
                <div class="feature-icon gray">📊</div>
                <h3>Pantau Status</h3>
                <p>Ikuti perkembangan pengaduan Anda dari diajukan, diproses, hingga selesai.</p>
            </div>
        </div>
    </section>

    <!-- ===== MAP SECTION ===== -->
    <section class="section" id="map-section">
        <div class="section-header reveal">
            <span class="section-label">Peta Pengaduan</span>
            <h2 class="section-title">Persebaran Pengaduan</h2>
            <p class="section-desc">Lihat lokasi pengaduan yang telah masuk dari seluruh wilayah.</p>
        </div>
        <div class="map-wrapper reveal" style="position:relative;">
            <div class="map-overlay">
                <h4>📍 Peta Realtime</h4>
                <p>Menampilkan {{ $pengaduans->count() }} lokasi pengaduan</p>
            </div>
            <div id="map"></div>
        </div>
    </section>

    <!-- ===== STATISTICS ===== -->
    <section class="section" id="stats">
        <div class="section-header reveal">
            <span class="section-label">Statistik</span>
            <h2 class="section-title">Data Pengaduan Terkini</h2>
        </div>
        <div class="stats-grid">
            <div class="stat-card reveal">
                <div class="stat-icon">📨</div>
                <div class="stat-number" data-target="{{ $stats['total'] }}">0</div>
                <div class="stat-label">Total Pengaduan</div>
            </div>
            <div class="stat-card reveal">
                <div class="stat-icon">⏳</div>
                <div class="stat-number" data-target="{{ $stats['total'] - $stats['selesai'] - $stats['diproses'] }}">0</div>
                <div class="stat-label">Diajukan</div>
            </div>
            <div class="stat-card reveal">
                <div class="stat-icon">🔄</div>
                <div class="stat-number" data-target="{{ $stats['diproses'] }}">0</div>
                <div class="stat-label">Sedang Diproses</div>
            </div>
            <div class="stat-card reveal">
                <div class="stat-icon">✅</div>
                <div class="stat-number" data-target="{{ $stats['selesai'] }}">0</div>
                <div class="stat-label">Selesai</div>
            </div>
        </div>
    </section>

    <!-- ===== CTA ===== -->
    <section class="cta-section">
        <div class="cta-card reveal">
            <h2>Siap menyampaikan aspirasi Anda?</h2>
            <p>Bergabunglah sekarang dan jadilah bagian dari perubahan positif di lingkungan Anda.</p>
            <div class="cta-buttons">
                @auth
                    <a href="{{ route('pengaduan.create') }}" class="btn btn-dark">Buat Pengaduan Sekarang</a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-dark">Daftar Gratis</a>
                    <a href="{{ route('login') }}" class="btn btn-light">Sudah Punya Akun?</a>
                @endauth
            </div>
        </div>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer class="footer">
        <p>&copy; {{ date('Y') }} Pengaduan Masyarakat — Kelurahan Meranti Pandak <span class="footer-heart">&hearts;</span></p>
    </footer>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>
    <script src="{{ asset('js/meranti-pandak-boundary.js') }}"></script>

    <script>
        // ===== NAVBAR SCROLL =====
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 50);
        });

        // ===== SCROLL REVEAL =====
        const revealElements = document.querySelectorAll('.reveal');
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('visible');
                    }, index * 80);
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });
        revealElements.forEach(el => revealObserver.observe(el));

        // ===== COUNTER ANIMATION =====
        const counters = document.querySelectorAll('.stat-number');
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = parseInt(entry.target.getAttribute('data-target'));
                    animateCounter(entry.target, target);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        counters.forEach(c => counterObserver.observe(c));

        function animateCounter(element, target) {
            const duration = 1500;
            const start = performance.now();
            function update(now) {
                const elapsed = now - start;
                const progress = Math.min(elapsed / duration, 1);
                const eased = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);
                element.textContent = Math.floor(eased * target);
                if (progress < 1) requestAnimationFrame(update);
            }
            requestAnimationFrame(update);
        }

        // ===== LEAFLET MAP =====
        const map = L.map('map', {
            scrollWheelZoom: false,
            zoomControl: true
        }).setView([0.5500, 101.4456], 15);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 19
        }).addTo(map);

        // Batas wilayah Kelurahan Meranti Pandak
        L.polygon(MERANTI_PANDAK_BOUNDARY, {
            color: '#111111',
            weight: 2,
            opacity: 0.6,
            fillColor: '#111111',
            fillOpacity: 0.04,
            dashArray: '6, 4'
        }).addTo(map);

        // Markers
        const pengaduans = @json($pengaduans);
        const bounds = [];

        pengaduans.forEach(p => {
            const statusColors = {
                'selesai': '#059669',
                'diproses': '#2563EB',
                'diajukan': '#D97706'
            };
            const markerColor = statusColors[p.status] || '#D97706';

            const icon = L.divIcon({
                className: 'custom-marker',
                html: `<div style="
                    width: 12px; height: 12px;
                    background: ${markerColor};
                    border-radius: 50%;
                    border: 2px solid #FFFFFF;
                    box-shadow: 0 1px 3px rgba(0,0,0,0.3);
                "></div>`,
                iconSize: [12, 12],
                iconAnchor: [6, 6]
            });

            const marker = L.marker([p.latitude, p.longitude], { icon }).addTo(map);
            marker.bindPopup(`
                <div class="popup-title">${p.judul}</div>
                <span class="popup-status ${p.status}">${p.status}</span>
            `);
            bounds.push([p.latitude, p.longitude]);
        });

        if (bounds.length > 0) {
            map.fitBounds(bounds, { padding: [50, 50], maxZoom: 14 });
        }
    </script>

</body>
</html>
