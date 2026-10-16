<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumentasi API Panel Admin - EZPICK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-72 bg-emerald-900 text-white flex flex-col shadow-xl hidden md:flex">
            <div class="p-6 border-b border-emerald-800">
                <h1 class="text-xl font-bold tracking-wider text-emerald-300">ADMIN API</h1>
                <p class="text-xs text-emerald-400 mt-1">Panel Admin Dokumentasi v1.0</p>
            </div>
            <nav class="flex-1 overflow-y-auto p-4 space-y-2 text-sm">
                <a href="#auth" class="block px-3 py-2 rounded hover:bg-emerald-800 transition">1. Autentikasi Admin</a>
                <a href="#menu" class="block px-3 py-2 rounded hover:bg-emerald-800 transition">2. Kelola Menu (Produk)</a>
                <a href="#category" class="block px-3 py-2 rounded hover:bg-emerald-800 transition">3. Kelola Kategori</a>
                <a href="#order" class="block px-3 py-2 rounded hover:bg-emerald-800 transition">4. Kelola Pesanan</a>
                <a href="#report" class="block px-3 py-2 rounded hover:bg-emerald-800 transition">5. Laporan Penjualan</a>
                <a href="#profile" class="block px-3 py-2 rounded hover:bg-emerald-800 transition">6. Profil Admin</a>
            </nav>
            <div class="p-4 border-t border-emerald-800 text-xs text-emerald-400 text-center">
                Base URL: <code class="bg-emerald-950 px-1.5 py-0.5 rounded text-emerald-200">http://localhost/backend_toko_online/admin/</code>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-6 md:p-10">
            <div class="max-w-4xl mx-auto space-y-12">
                
                <!-- Header Banner -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h2 class="text-2xl font-bold text-gray-900">Dokumentasi API Panel Admin EZPICK</h2>
                    <p class="text-gray-600 mt-1 text-sm">Seluruh endpoint di bawah ini menggunakan metode <span class="font-semibold text-emerald-600">POST</span> dengan payload <span class="font-semibold text-emerald-600">form-data</span> pada Postman.</p>
                </div>

                <!-- 1. AUTH ADMIN -->
                <section id="auth" class="space-y-4">
                    <h3 class="text-xl font-bold text-emerald-900 border-b pb-2">1. Autentikasi Admin</h3>
                    
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">POST</span>
                            <code class="text-sm font-mono text-gray-700">/auth/login</code>
                        </div>
                        <p class="text-sm text-gray-600">Digunakan untuk masuk ke sistem Panel Admin.</p>
                        <div>
                            <h4 class="text-xs font-bold uppercase text-gray-500 mb-1">Parameter (form-data):</h4>
                            <ul class="text-xs space-y-1 text-gray-700 font-mono bg-gray-50 p-3 rounded border">
                                <li>username (string, wajib) &rarr; <span class="text-emerald-700 font-semibold">admin</span></li>
                                <li>password (string, wajib) &rarr; <span class="text-emerald-700 font-semibold">admin123</span></li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- 2. KELOLA MENU -->
                <section id="menu" class="space-y-4">
                    <h3 class="text-xl font-bold text-emerald-900 border-b pb-2">2. Kelola Menu (Produk)</h3>
                    
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">POST</span>
                            <code class="text-sm font-mono text-gray-700">/menu/list</code>
                        </div>
                        <p class="text-sm text-gray-600">Menampilkan seluruh daftar menu produk beserta ringkasan status stok (Tersedia / Habis).</p>
                        <p class="text-xs text-gray-400">Parameter: <i>Tanpa parameter (kosong)</i></p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">POST</span>
                            <code class="text-sm font-mono text-gray-700">/menu/detail</code>
                        </div>
                        <p class="text-sm text-gray-600">Menampilkan detail informasi lengkap satu menu.</p>
                        <div>
                            <h4 class="text-xs font-bold uppercase text-gray-500 mb-1">Parameter (form-data):</h4>
                            <ul class="text-xs space-y-1 text-gray-700 font-mono bg-gray-50 p-3 rounded border">
                                <li>product_id (int, wajib) &rarr; cth: 1</li>
                            </ul>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">POST</span>
                            <code class="text-sm font-mono text-gray-700">/menu/create</code>
                        </div>
                        <p class="text-sm text-gray-600">Menambahkan menu atau produk baru ke dalam katalog resto.</p>
                        <div>
                            <h4 class="text-xs font-bold uppercase text-gray-500 mb-1">Parameter (form-data):</h4>
                            <ul class="text-xs space-y-1 text-gray-700 font-mono bg-gray-50 p-3 rounded border">
                                <li>category_id (int, wajib)</li>
                                <li>name (string, wajib)</li>
                                <li>price (decimal, wajib)</li>
                                <li>description (string, opsional)</li>
                                <li>is_best_seller (int: 1 / 0)</li>
                                <li>image (file image, opsional)</li>
                            </ul>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">POST</span>
                            <code class="text-sm font-mono text-gray-700">/menu/toggle-stock</code>
                        </div>
                        <p class="text-sm text-gray-600">Mengubah status centang ketersediaan stok menu secara instan.</p>
                        <div>
                            <h4 class="text-xs font-bold uppercase text-gray-500 mb-1">Parameter (form-data):</h4>
                            <ul class="text-xs space-y-1 text-gray-700 font-mono bg-gray-50 p-3 rounded border">
                                <li>product_id (int, wajib)</li>
                                <li>is_available (int, wajib: 1 = Tersedia, 0 = Stok Habis)</li>
                            </ul>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">POST</span>
                            <code class="text-sm font-mono text-gray-700">/menu/delete</code>
                        </div>
                        <p class="text-sm text-gray-600">Menghapus menu dari database.</p>
                        <div>
                            <h4 class="text-xs font-bold uppercase text-gray-500 mb-1">Parameter (form-data):</h4>
                            <ul class="text-xs space-y-1 text-gray-700 font-mono bg-gray-50 p-3 rounded border">
                                <li>product_id (int, wajib)</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- 3. KELOLA KATEGORI -->
                <section id="category" class="space-y-4">
                    <h3 class="text-xl font-bold text-emerald-900 border-b pb-2">3. Kelola Kategori</h3>
                    
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">POST</span>
                            <code class="text-sm font-mono text-gray-700">/category/list</code>
                        </div>
                        <p class="text-sm text-gray-600">Menampilkan daftar kategori beserta jumlah menu di setiap kategori.</p>
                        <p class="text-xs text-gray-400">Parameter: <i>Tanpa parameter (kosong)</i></p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">POST</span>
                            <code class="text-sm font-mono text-gray-700">/category/create</code>
                        </div>
                        <p class="text-sm text-gray-600">Menambahkan kategori menu baru.</p>
                        <div>
                            <h4 class="text-xs font-bold uppercase text-gray-500 mb-1">Parameter (form-data):</h4>
                            <ul class="text-xs space-y-1 text-gray-700 font-mono bg-gray-50 p-3 rounded border">
                                <li>name (string, wajib) &rarr; cth: "Snack"</li>
                            </ul>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">POST</span>
                            <code class="text-sm font-mono text-gray-700">/category/delete</code>
                        </div>
                        <p class="text-sm text-gray-600">Menghapus kategori (Gagal otomatis jika kategori masih dipakai produk).</p>
                        <div>
                            <h4 class="text-xs font-bold uppercase text-gray-500 mb-1">Parameter (form-data):</h4>
                            <ul class="text-xs space-y-1 text-gray-700 font-mono bg-gray-50 p-3 rounded border">
                                <li>category_id (int, wajib)</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- 4. KELOLA PESANAN -->
                <section id="order" class="space-y-4">
                    <h3 class="text-xl font-bold text-emerald-900 border-b pb-2">4. Kelola Pesanan</h3>
                    
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">POST</span>
                            <code class="text-sm font-mono text-gray-700">/order/list</code>
                        </div>
                        <p class="text-sm text-gray-600">Menampilkan daftar semua pesanan masuk dari pelanggan.</p>
                        <p class="text-xs text-gray-400">Parameter: <i>Tanpa parameter (kosong)</i></p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">POST</span>
                            <code class="text-sm font-mono text-gray-700">/order/detail</code>
                        </div>
                        <p class="text-sm text-gray-600">Menampilkan rincian pesanan dan informasi pelanggan.</p>
                        <div>
                            <h4 class="text-xs font-bold uppercase text-gray-500 mb-1">Parameter (form-data):</h4>
                            <ul class="text-xs space-y-1 text-gray-700 font-mono bg-gray-50 p-3 rounded border">
                                <li>order_id (int, wajib)</li>
                            </ul>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">POST</span>
                            <code class="text-sm font-mono text-gray-700">/order/update-status</code>
                        </div>
                        <p class="text-sm text-gray-600">Mengubah status tahapan pesanan masuk.</p>
                        <div>
                            <h4 class="text-xs font-bold uppercase text-gray-500 mb-1">Parameter (form-data):</h4>
                            <ul class="text-xs space-y-1 text-gray-700 font-mono bg-gray-50 p-3 rounded border">
                                <li>order_id (int, wajib)</li>
                                <li>status (string, wajib: "Diproses", "Siap", atau "Selesai")</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- 5. LAPORAN PENJUALAN -->
                <section id="report" class="space-y-4">
                    <h3 class="text-xl font-bold text-emerald-900 border-b pb-2">5. Laporan Penjualan</h3>
                    
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">POST</span>
                            <code class="text-sm font-mono text-gray-700">/report/summary</code>
                        </div>
                        <p class="text-sm text-gray-600">Menampilkan ringkasan laporan penjualan, total pendapatan, rata-rata, dan menu terlaris.</p>
                        <p class="text-xs text-gray-400">Parameter: <i>Tanpa parameter (kosong)</i></p>
                    </div>
                </section>

                <!-- 6. PROFIL ADMIN -->
                <section id="profile" class="space-y-4">
                    <h3 class="text-xl font-bold text-emerald-900 border-b pb-2">6. Profil Admin</h3>
                    
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">POST</span>
                            <code class="text-sm font-mono text-gray-700">/profile/get</code>
                        </div>
                        <p class="text-sm text-gray-600">Mengambil informasi profil akun admin yang sedang aktif.</p>
                        <div>
                            <h4 class="text-xs font-bold uppercase text-gray-500 mb-1">Parameter (form-data):</h4>
                            <ul class="text-xs space-y-1 text-gray-700 font-mono bg-gray-50 p-3 rounded border">
                                <li>admin_id (int, wajib) &rarr; cth: 1</li>
                            </ul>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">POST</span>
                            <code class="text-sm font-mono text-gray-700">/profile/update</code>
                        </div>
                        <p class="text-sm text-gray-600">Memperbarui nama panggilan (nickname) admin.</p>
                        <div>
                            <h4 class="text-xs font-bold uppercase text-gray-500 mb-1">Parameter (form-data):</h4>
                            <ul class="text-xs space-y-1 text-gray-700 font-mono bg-gray-50 p-3 rounded border">
                                <li>admin_id (int, wajib)</li>
                                <li>nickname (string, wajib) &rarr; cth: "Super Admin"</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <footer class="text-center py-8 text-xs text-gray-400 border-t">
                    EZPICK Admin Panel API Documentation &bull; Ready for Postman Testing
                </footer>

            </div>
        </main>
    </div>

</body>
</html>