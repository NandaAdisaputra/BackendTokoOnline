<!-- Top Header -->
<header class="bg-emerald-900 text-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="flex items-center space-x-3">
            <div class="bg-emerald-800 p-2.5 rounded-xl border border-emerald-700 shadow-inner">
                <i class="fa-solid fa-shield-halved text-2xl text-emerald-300"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold tracking-tight">EZPICK Admin Panel API</h1>
                <p class="text-xs text-emerald-200">Dokumentasi Endpoint & Panduan Postman</p>
            </div>
        </div>
        <!-- Search Bar -->
        <div class="w-full md:w-80">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="fa-solid fa-search"></i>
                </span>
                <input type="text" id="searchInput" onkeyup="filterEndpoints()" placeholder="Cari endpoint atau menu..." class="w-full pl-10 pr-4 py-2 bg-emerald-950/60 text-sm text-white placeholder-emerald-300/60 rounded-lg border border-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-400 transition">
            </div>
        </div>
    </div>
</header>

<!-- Main Container -->
<main class="max-w-7xl mx-auto px-6 py-8 grid grid-cols-1 lg:grid-cols-4 gap-8">
    
    <!-- Sidebar Navigation -->
    <aside class="hidden lg:block lg:col-span-1">
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 sticky top-24">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Navigasi Cepat</h3>
            <nav class="space-y-1.5 text-sm font-medium">
                <a href="#info" class="flex items-center space-x-3 px-3 py-2 rounded-lg text-slate-600 hover:bg-emerald-50 hover:text-emerald-800 transition"><i class="fa-solid fa-circle-info w-5"></i> <span>Info Dasar</span></a>
                <a href="#auth" class="flex items-center space-x-3 px-3 py-2 rounded-lg text-slate-600 hover:bg-emerald-50 hover:text-emerald-800 transition"><i class="fa-solid fa-key w-5"></i> <span>1. Autentikasi</span></a>
                <a href="#menu" class="flex items-center space-x-3 px-3 py-2 rounded-lg text-slate-600 hover:bg-emerald-50 hover:text-emerald-800 transition"><i class="fa-solid fa-utensils w-5"></i> <span>2. Kelola Menu</span></a>
                <a href="#category" class="flex items-center space-x-3 px-3 py-2 rounded-lg text-slate-600 hover:bg-emerald-50 hover:text-emerald-800 transition"><i class="fa-solid fa-tags w-5"></i> <span>3. Kategori</span></a>
                <a href="#order" class="flex items-center space-x-3 px-3 py-2 rounded-lg text-slate-600 hover:bg-emerald-50 hover:text-emerald-800 transition"><i class="fa-solid fa-receipt w-5"></i> <span>4. Kelola Pesanan</span></a>
                <a href="#report" class="flex items-center space-x-3 px-3 py-2 rounded-lg text-slate-600 hover:bg-emerald-50 hover:text-emerald-800 transition"><i class="fa-solid fa-chart-line w-5"></i> <span>5. Laporan & Profil</span></a>
            </nav>
        </div>
    </aside>

    <!-- Content Area -->
    <div class="lg:col-span-3 space-y-8" id="contentArea">
        
        <!-- Base Info Card -->
        <section id="info" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 api-section">
            <h2 class="text-lg font-bold text-slate-900 mb-3 flex items-center space-x-2">
                <i class="fa-solid fa-circle-info text-emerald-600"></i>
                <span>Informasi Koneksi & Testing</span>
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                    <span class="block text-xs font-bold text-slate-400 uppercase">Base URL Admin</span>
                    <div class="flex items-center justify-between mt-1">
                        <code id="baseUrlText" class="text-pink-600 font-mono text-xs font-semibold">http://localhost/backend_toko_online/admin/</code>
                        <button onclick="copyCode('http://localhost/backend_toko_online/admin/')" class="text-slate-400 hover:text-emerald-700 transition" title="Salin URL"><i class="fa-regular fa-copy"></i></button>
                    </div>
                </div>
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                    <span class="block text-xs font-bold text-slate-400 uppercase">Postman Format</span>
                    <span class="font-semibold text-slate-700 mt-1 block">Method: <span class="text-blue-600 font-bold">POST</span> | Body: <span class="text-emerald-700 font-bold">form-data</span></span>
                </div>
            </div>
        </section>

        <!-- 1. AUTH -->
        <section id="auth" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 api-section">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
                <h2 class="text-lg font-bold text-slate-900">1. Autentikasi Admin</h2>
                <span class="bg-emerald-100 text-emerald-800 text-xs px-2.5 py-1 rounded-full font-semibold">Screen 01</span>
            </div>

            <div class="space-y-4">
                <div class="border border-slate-200 rounded-xl p-4 bg-slate-50/50 endpoint-item">
                    <div class="flex items-center space-x-3 mb-2">
                        <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded font-bold uppercase">POST</span>
                        <code class="text-pink-600 font-mono font-bold text-sm">/auth/login</code>
                    </div>
                    <p class="text-sm text-slate-600 mb-3">Digunakan untuk login ke panel admin dan mendapatkan data sesi admin.</p>
                    
                    <h4 class="text-xs font-bold uppercase text-slate-400 mb-2">Parameter (form-data):</h4>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm border-collapse bg-white rounded-lg overflow-hidden border border-slate-200">
                            <tr class="bg-slate-100 text-slate-700"><th class="p-2.5 border">Key</th><th class="p-2.5 border">Type</th><th class="p-2.5 border">Contoh Value</th></tr>
                            <tr><td class="p-2.5 border font-mono text-emerald-800 font-semibold">username</td><td class="p-2.5 border text-slate-500">Text</td><td class="p-2.5 border font-mono">admin</td></tr>
                            <tr><td class="p-2.5 border font-mono text-emerald-800 font-semibold">password</td><td class="p-2.5 border text-slate-500">Text</td><td class="p-2.5 border font-mono">admin123</td></tr>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <!-- 2. KELOLA MENU -->
        <section id="menu" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 api-section">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
                <h2 class="text-lg font-bold text-slate-900">2. Kelola Menu / Produk</h2>
                <span class="bg-emerald-100 text-emerald-800 text-xs px-2.5 py-1 rounded-full font-semibold">Screen 02 - 04</span>
            </div>

            <div class="space-y-6">
                <!-- List -->
                <div class="border border-slate-200 rounded-xl p-4 bg-slate-50/50 endpoint-item">
                    <div class="flex items-center space-x-3 mb-2">
                        <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded font-bold uppercase">POST</span>
                        <code class="text-pink-600 font-mono font-bold text-sm">/menu/list</code>
                    </div>
                    <p class="text-sm text-slate-600">Menampilkan seluruh daftar menu beserta ringkasan status stok (tersedia & habis).</p>
                    <p class="text-xs text-slate-400 mt-2 font-medium">Parameter: <i>Tanpa parameter (kosong)</i></p>
                </div>

                <!-- Detail -->
                <div class="border border-slate-200 rounded-xl p-4 bg-slate-50/50 endpoint-item">
                    <div class="flex items-center space-x-3 mb-2">
                        <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded font-bold uppercase">POST</span>
                        <code class="text-pink-600 font-mono font-bold text-sm">/menu/detail</code>
                    </div>
                    <p class="text-sm text-slate-600 mb-3">Melihat detail spesifik dari satu menu.</p>
                    <table class="w-full text-left text-sm border-collapse bg-white rounded-lg overflow-hidden border border-slate-200">
                        <tr class="bg-slate-100 text-slate-700"><th class="p-2.5 border">Key</th><th class="p-2.5 border">Contoh Value</th></tr>
                        <tr><td class="p-2.5 border font-mono text-emerald-800 font-semibold">product_id</td><td class="p-2.5 border font-mono">1</td></tr>
                    </table>
                </div>

                <!-- Create -->
                <div class="border border-slate-200 rounded-xl p-4 bg-slate-50/50 endpoint-item">
                    <div class="flex items-center space-x-3 mb-2">
                        <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded font-bold uppercase">POST</span>
                        <code class="text-pink-600 font-mono font-bold text-sm">/menu/create</code>
                    </div>
                    <p class="text-sm text-slate-600 mb-3">Menambahkan menu atau produk baru ke katalog.</p>
                    <table class="w-full text-left text-sm border-collapse bg-white rounded-lg overflow-hidden border border-slate-200">
                        <tr class="bg-slate-100 text-slate-700"><th class="p-2.5 border">Key</th><th class="p-2.5 border">Type</th><th class="p-2.5 border">Keterangan / Contoh</th></tr>
                        <tr><td class="p-2.5 border font-mono text-emerald-800 font-semibold">category_id</td><td class="p-2.5 border text-slate-500">Text</td><td class="p-2.5 border">ID Kategori (Cth: 1)</td></tr>
                        <tr><td class="p-2.5 border font-mono text-emerald-800 font-semibold">name</td><td class="p-2.5 border text-slate-500">Text</td><td class="p-2.5 border">Ayam Bakar Madu</td></tr>
                        <tr><td class="p-2.5 border font-mono text-emerald-800 font-semibold">price</td><td class="p-2.5 border text-slate-500">Text</td><td class="p-2.5 border">25000</td></tr>
                        <tr><td class="p-2.5 border font-mono text-emerald-800 font-semibold">description</td><td class="p-2.5 border text-slate-500">Text</td><td class="p-2.5 border">Deskripsi singkat menu</td></tr>
                        <tr><td class="p-2.5 border font-mono text-emerald-800 font-semibold">is_best_seller</td><td class="p-2.5 border text-slate-500">Text</td><td class="p-2.5 border">1 (Ya) atau 0 (Tidak)</td></tr>
                        <tr><td class="p-2.5 border font-mono text-emerald-800 font-semibold">image</td><td class="p-2.5 border text-slate-500">File</td><td class="p-2.5 border">Pilih file foto menu (opsional)</td></tr>
                    </table>
                </div>

                <!-- Toggle Stock -->
                <div class="border border-slate-200 rounded-xl p-4 bg-slate-50/50 endpoint-item">
                    <div class="flex items-center space-x-3 mb-2">
                        <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded font-bold uppercase">POST</span>
                        <code class="text-pink-600 font-mono font-bold text-sm">/menu/toggle-stock</code>
                    </div>
                    <p class="text-sm text-slate-600 mb-3">Mengubah status centang ketersediaan stok produk secara instan.</p>
                    <table class="w-full text-left text-sm border-collapse bg-white rounded-lg overflow-hidden border border-slate-200">
                        <tr class="bg-slate-100 text-slate-700"><th class="p-2.5 border">Key</th><th class="p-2.5 border">Contoh Value</th></tr>
                        <tr><td class="p-2.5 border font-mono text-emerald-800 font-semibold">product_id</td><td class="p-2.5 border font-mono">1</td></tr>
                        <tr><td class="p-2.5 border font-mono text-emerald-800 font-semibold">is_available</td><td class="p-2.5 border font-mono">0 (Habis) atau 1 (Tersedia)</td></tr>
                    </table>
                </div>

                <!-- Delete -->
                <div class="border border-slate-200 rounded-xl p-4 bg-slate-50/50 endpoint-item">
                    <div class="flex items-center space-x-3 mb-2">
                        <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded font-bold uppercase">POST</span>
                        <code class="text-pink-600 font-mono font-bold text-sm">/menu/delete</code>
                    </div>
                    <p class="text-sm text-slate-600 mb-3">Menghapus menu dari database.</p>
                    <table class="w-full text-left text-sm border-collapse bg-white rounded-lg overflow-hidden border border-slate-200">
                        <tr class="bg-slate-100 text-slate-700"><th class="p-2.5 border">Key</th><th class="p-2.5 border">Contoh Value</th></tr>
                        <tr><td class="p-2.5 border font-mono text-emerald-800 font-semibold">product_id</td><td class="p-2.5 border font-mono">1</td></tr>
                    </table>
                </div>
            </div>
        </section>

        <!-- 3. KELOLA KATEGORI -->
        <section id="category" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 api-section">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
                <h2 class="text-lg font-bold text-slate-900">3. Kelola Kategori</h2>
                <span class="bg-emerald-100 text-emerald-800 text-xs px-2.5 py-1 rounded-full font-semibold">Screen 05 - 06</span>
            </div>

            <div class="space-y-4">
                <div class="border border-slate-200 rounded-xl p-4 bg-slate-50/50 endpoint-item">
                    <div class="flex items-center space-x-3 mb-2">
                        <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded font-bold uppercase">POST</span>
                        <code class="text-pink-600 font-mono font-bold text-sm">/category/list</code>
                    </div>
                    <p class="text-sm text-slate-600">Menampilkan daftar kategori beserta jumlah total menu di dalamnya.</p>
                </div>

                <div class="border border-slate-200 rounded-xl p-4 bg-slate-50/50 endpoint-item">
                    <div class="flex items-center space-x-3 mb-2">
                        <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded font-bold uppercase">POST</span>
                        <code class="text-pink-600 font-mono font-bold text-sm">/category/create</code>
                    </div>
                    <p class="text-sm text-slate-600 mb-3">Menambah kategori produk baru.</p>
                    <table class="w-full text-left text-sm border-collapse bg-white rounded-lg overflow-hidden border border-slate-200">
                        <tr class="bg-slate-100 text-slate-700"><th class="p-2.5 border">Key</th><th class="p-2.5 border">Contoh Value</th></tr>
                        <tr><td class="p-2.5 border font-mono text-emerald-800 font-semibold">name</td><td class="p-2.5 border">Snack & Dessert</td></tr>
                    </table>
                </div>

                <div class="border border-slate-200 rounded-xl p-4 bg-slate-50/50 endpoint-item">
                    <div class="flex items-center space-x-3 mb-2">
                        <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded font-bold uppercase">POST</span>
                        <code class="text-pink-600 font-mono font-bold text-sm">/category/delete</code>
                    </div>
                    <p class="text-sm text-slate-600 mb-3">Menghapus kategori (Gagal jika masih ada produk terkait).</p>
                    <table class="w-full text-left text-sm border-collapse bg-white rounded-lg overflow-hidden border border-slate-200">
                        <tr class="bg-slate-100 text-slate-700"><th class="p-2.5 border">Key</th><th class="p-2.5 border">Contoh Value</th></tr>
                        <tr><td class="p-2.5 border font-mono text-emerald-800 font-semibold">category_id</td><td class="p-2.5 border font-mono">3</td></tr>
                    </table>
                </div>
            </div>
        </section>

        <!-- 4. KELOLA PESANAN -->
        <section id="order" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 api-section">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
                <h2 class="text-lg font-bold text-slate-900">4. Kelola Pesanan & Status</h2>
                <span class="bg-emerald-100 text-emerald-800 text-xs px-2.5 py-1 rounded-full font-semibold">Screen 07 - 08</span>
            </div>

            <div class="space-y-4">
                <div class="border border-slate-200 rounded-xl p-4 bg-slate-50/50 endpoint-item">
                    <div class="flex items-center space-x-3 mb-2">
                        <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded font-bold uppercase">POST</span>
                        <code class="text-pink-600 font-mono font-bold text-sm">/order/list</code>
                    </div>
                    <p class="text-sm text-slate-600">Menampilkan daftar seluruh pesanan masuk dari pelanggan.</p>
                </div>

                <div class="border border-slate-200 rounded-xl p-4 bg-slate-50/50 endpoint-item">
                    <div class="flex items-center space-x-3 mb-2">
                        <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded font-bold uppercase">POST</span>
                        <code class="text-pink-600 font-mono font-bold text-sm">/order/detail</code>
                    </div>
                    <p class="text-sm text-slate-600 mb-3">Melihat rincian detail pesanan dan item produk.</p>
                    <table class="w-full text-left text-sm border-collapse bg-white rounded-lg overflow-hidden border border-slate-200">
                        <tr class="bg-slate-100 text-slate-700"><th class="p-2.5 border">Key</th><th class="p-2.5 border">Contoh Value</th></tr>
                        <tr><td class="p-2.5 border font-mono text-emerald-800 font-semibold">order_id</td><td class="p-2.5 border font-mono">1</td></tr>
                    </table>
                </div>

                <div class="border border-slate-200 rounded-xl p-4 bg-slate-50/50 endpoint-item">
                    <div class="flex items-center space-x-3 mb-2">
                        <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded font-bold uppercase">POST</span>
                        <code class="text-pink-600 font-mono font-bold text-sm">/order/update-status</code>
                    </div>
                    <p class="text-sm text-slate-600 mb-3">Mengubah status tahapan pesanan pelanggan.</p>
                    <table class="w-full text-left text-sm border-collapse bg-white rounded-lg overflow-hidden border border-slate-200">
                        <tr class="bg-slate-100 text-slate-700"><th class="p-2.5 border">Key</th><th class="p-2.5 border">Keterangan / Value</th></tr>
                        <tr><td class="p-2.5 border font-mono text-emerald-800 font-semibold">order_id</td><td class="p-2.5 border font-mono">1</td></tr>
                        <tr><td class="p-2.5 border font-mono text-emerald-800 font-semibold">status</td><td class="p-2.5 border">Pilihan: <code class="text-emerald-700">Diproses</code>, <code class="text-emerald-700">Siap</code>, <code class="text-emerald-700">Selesai</code></td></tr>
                    </table>
                </div>
            </div>
        </section>

        <!-- 5. LAPORAN & PROFIL -->
        <section id="report" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 api-section">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
                <h2 class="text-lg font-bold text-slate-900">5. Laporan & Profil Admin</h2>
                <span class="bg-emerald-100 text-emerald-800 text-xs px-2.5 py-1 rounded-full font-semibold">Screen 09 - 11</span>
            </div>

            <div class="space-y-4">
                <div class="border border-slate-200 rounded-xl p-4 bg-slate-50/50 endpoint-item">
                    <div class="flex items-center space-x-3 mb-2">
                        <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded font-bold uppercase">POST</span>
                        <code class="text-pink-600 font-mono font-bold text-sm">/report/summary</code>
                    </div>
                    <p class="text-sm text-slate-600">Menampilkan ringkasan total pesanan, total pendapatan, rata-rata, dan menu terlaris.</p>
                </div>

                <div class="border border-slate-200 rounded-xl p-4 bg-slate-50/50 endpoint-item">
                    <div class="flex items-center space-x-3 mb-2">
                        <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded font-bold uppercase">POST</span>
                        <code class="text-pink-600 font-mono font-bold text-sm">/profile/get</code>
                    </div>
                    <p class="text-sm text-slate-600 mb-3">Mengambil data profil admin yang aktif.</p>
                    <table class="w-full text-left text-sm border-collapse bg-white rounded-lg overflow-hidden border border-slate-200">
                        <tr class="bg-slate-100 text-slate-700"><th class="p-2.5 border">Key</th><th class="p-2.5 border">Contoh Value</th></tr>
                        <tr><td class="p-2.5 border font-mono text-emerald-800 font-semibold">admin_id</td><td class="p-2.5 border font-mono">1</td></tr>
                    </table>
                </div>

                <div class="border border-slate-200 rounded-xl p-4 bg-slate-50/50 endpoint-item">
                    <div class="flex items-center space-x-3 mb-2">
                        <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded font-bold uppercase">POST</span>
                        <code class="text-pink-600 font-mono font-bold text-sm">/profile/update</code>
                    </div>
                    <p class="text-sm text-slate-600 mb-3">Memperbarui nama panggilan (nickname) admin.</p>
                    <table class="w-full text-left text-sm border-collapse bg-white rounded-lg overflow-hidden border border-slate-200">
                        <tr class="bg-slate-100 text-slate-700"><th class="p-2.5 border">Key</th><th class="p-2.5 border">Contoh Value</th></tr>
                        <tr><td class="p-2.5 border font-mono text-emerald-800 font-semibold">admin_id</td><td class="p-2.5 border font-mono">1</td></tr>
                        <tr><td class="p-2.5 border font-mono text-emerald-800 font-semibold">nickname</td><td class="p-2.5 border">Super Admin</td></tr>
                    </table>
                </div>
            </div>
        </section>

    </div>

</main>

<!-- Footer -->
<footer class="bg-white border-t border-slate-200 mt-16 py-6 text-center text-xs text-slate-500">
    <p>EZPICK API Documentation &copy; 2026 &bull; All Rights Reserved</p>
</footer>

<!-- Script Utilities -->
<script>
    function filterEndpoints() {
        let input = document.getElementById('searchInput').value.toLowerCase();
        let sections = document.getElementsByClassName('api-section');

        for (let i = 0; i < sections.length; i++) {
            let text = sections[i].innerText.toLowerCase();
            if (text.includes(input)) {
                sections[i].style.display = "";
            } else {
                sections[i].style.display = "none";
            }
        }
    }

    function copyCode(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert('Base URL berhasil disalin ke clipboard!');
        });
    }
</script>
