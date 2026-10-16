<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumentasi API Panel Admin - EZPICK</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-relaxed text-gray-800">
    <div class="max-w-4xl mx-auto my-10 bg-white p-8 rounded-xl shadow-lg border border-gray-200">
        <h1 class="text-3xl font-bold text-emerald-900 border-b-2 border-emerald-800 pb-3 mb-4">🛡️ Panel Admin API Documentation</h1>
        <p class="text-sm text-gray-600 mb-2">Base URL: <code class="bg-gray-100 px-2 py-1 rounded text-pink-600 font-mono">http://localhost/backend_toko_online/admin/</code></p>
        <p class="text-sm text-gray-500 mb-6">Metode Request: <strong class="text-emerald-700">POST</strong> | Format Body Postman: <strong class="text-emerald-700">form-data</strong></p>

        <!-- 1. Autentikasi Admin -->
        <div class="mb-8 border-l-4 border-emerald-600 bg-gray-50 p-5 rounded-r-lg shadow-sm">
            <h2 class="text-xl font-bold text-emerald-800 mb-3">1. Autentikasi Admin</h2>
            <div class="mb-4 bg-white p-4 rounded shadow-sm">
                <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded font-bold">POST</span> 
                <code class="text-pink-600 font-semibold ml-2">/auth/login</code>
                <p class="text-sm text-gray-600 mt-1">Digunakan untuk masuk ke panel admin.</p>
                <table class="w-full text-left text-sm border-collapse bg-white rounded mt-3">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700"><th class="border p-2">Key (form-data)</th><th class="border p-2">Type</th><th class="border p-2">Keterangan</th></tr>
                    </thead>
                    <tbody>
                        <tr><td class="border p-2 font-mono">username</td><td class="border p-2">Text</td><td class="border p-2"><code>admin</code></td></tr>
                        <tr><td class="border p-2 font-mono">password</td><td class="border p-2">Text</td><td class="border p-2"><code>admin123</code></td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 2. Kelola Menu (Produk) -->
        <div class="mb-8 border-l-4 border-emerald-600 bg-gray-50 p-5 rounded-r-lg shadow-sm">
            <h2 class="text-xl font-bold text-emerald-800 mb-3">2. Kelola Menu (Produk)</h2>
            
            <!-- List Menu -->
            <div class="mb-4 bg-white p-4 rounded shadow-sm">
                <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded font-bold">POST</span> 
                <code class="text-pink-600 font-semibold ml-2">/menu/list</code>
                <p class="text-sm text-gray-600 mt-1">Menampilkan seluruh daftar menu dan ringkasan status stok.</p>
                <p class="text-xs text-gray-400 mt-2">Parameter: <i>Tanpa parameter (kosong)</i></p>
            </div>

            <!-- Detail Menu -->
            <div class="mb-4 bg-white p-4 rounded shadow-sm">
                <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded font-bold">POST</span> 
                <code class="text-pink-600 font-semibold ml-2">/menu/detail</code>
                <p class="text-sm text-gray-600 mt-1">Menampilkan detail informasi satu menu berdasarkan ID.</p>
                <table class="w-full text-left text-sm border-collapse bg-white rounded mt-3">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700"><th class="border p-2">Key (form-data)</th><th class="border p-2">Type</th><th class="border p-2">Keterangan</th></tr>
                    </thead>
                    <tbody>
                        <tr><td class="border p-2 font-mono">product_id</td><td class="border p-2">Text</td><td class="border p-2">ID Produk (Cth: <code>1</code>)</td></tr>
                    </tbody>
                </table>
            </div>

            <!-- Tambah Menu -->
            <div class="mb-4 bg-white p-4 rounded shadow-sm">
                <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded font-bold">POST</span> 
                <code class="text-pink-600 font-semibold ml-2">/menu/create</code>
                <p class="text-sm text-gray-600 mt-1">Menambahkan menu atau produk baru ke katalog.</p>
                <table class="w-full text-left text-sm border-collapse bg-white rounded mt-3">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700"><th class="border p-2">Key (form-data)</th><th class="border p-2">Type</th><th class="border p-2">Keterangan</th></tr>
                    </thead>
                    <tbody>
                        <tr><td class="border p-2 font-mono">category_id</td><td class="border p-2">Text</td><td class="border p-2">ID Kategori (Cth: <code>1</code>)</td></tr>
                        <tr><td class="border p-2 font-mono">name</td><td class="border p-2">Text</td><td class="border p-2">Nama Menu (Cth: <code>Ayam Bakar Madu</code>)</td></tr>
                        <tr><td class="border p-2 font-mono">price</td><td class="border p-2">Text</td><td class="border p-2">Harga (Cth: <code>25000</code>)</td></tr>
                        <tr><td class="border p-2 font-mono">description</td><td class="border p-2">Text</td><td class="border p-2">Deskripsi singkat menu</td></tr>
                        <tr><td class="border p-2 font-mono">is_best_seller</td><td class="border p-2">Text</td><td class="border p-2"><code>1</code> (Ya) atau <code>0</code> (Tidak)</td></tr>
                        <tr><td class="border p-2 font-mono">image</td><td class="border p-2">File</td><td class="border p-2">File gambar produk (Opsional)</td></tr>
                    </tbody>
                </table>
            </div>

            <!-- Toggle Stock -->
            <div class="mb-4 bg-white p-4 rounded shadow-sm">
                <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded font-bold">POST</span> 
                <code class="text-pink-600 font-semibold ml-2">/menu/toggle-stock</code>
                <p class="text-sm text-gray-600 mt-1">Mengubah status ketersediaan stok menu secara instan.</p>
                <table class="w-full text-left text-sm border-collapse bg-white rounded mt-3">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700"><th class="border p-2">Key (form-data)</th><th class="border p-2">Type</th><th class="border p-2">Keterangan</th></tr>
                    </thead>
                    <tbody>
                        <tr><td class="border p-2 font-mono">product_id</td><td class="border p-2">Text</td><td class="border p-2">ID Produk</td></tr>
                        <tr><td class="border p-2 font-mono">is_available</td><td class="border p-2">Text</td><td class="border p-2"><code>1</code> (Tersedia) atau <code>0</code> (Stok Habis)</td></tr>
                    </tbody>
                </table>
            </div>

            <!-- Delete Menu -->
            <div class="bg-white p-4 rounded shadow-sm">
                <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded font-bold">POST</span> 
                <code class="text-pink-600 font-semibold ml-2">/menu/delete</code>
                <p class="text-sm text-gray-600 mt-1">Menghapus menu dari database.</p>
                <table class="w-full text-left text-sm border-collapse bg-white rounded mt-3">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700"><th class="border p-2">Key (form-data)</th><th class="border p-2">Type</th><th class="border p-2">Keterangan</th></tr>
                    </thead>
                    <tbody>
                        <tr><td class="border p-2 font-mono">product_id</td><td class="border p-2">Text</td><td class="border p-2">ID Produk yang akan dihapus</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 3. Kelola Kategori -->
        <div class="mb-8 border-l-4 border-emerald-600 bg-gray-50 p-5 rounded-r-lg shadow-sm">
            <h2 class="text-xl font-bold text-emerald-800 mb-3">3. Kelola Kategori</h2>
            
            <div class="mb-4 bg-white p-4 rounded shadow-sm">
                <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded font-bold">POST</span> 
                <code class="text-pink-600 font-semibold ml-2">/category/list</code>
                <p class="text-sm text-gray-600 mt-1">Menampilkan daftar kategori dan jumlah menu di setiap kategori.</p>
            </div>

            <div class="mb-4 bg-white p-4 rounded shadow-sm">
                <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded font-bold">POST</span> 
                <code class="text-pink-600 font-semibold ml-2">/category/create</code>
                <p class="text-sm text-gray-600 mt-1">Menambahkan kategori baru.</p>
                <table class="w-full text-left text-sm border-collapse bg-white rounded mt-3">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700"><th class="border p-2">Key (form-data)</th><th class="border p-2">Type</th><th class="border p-2">Keterangan</th></tr>
                    </thead>
                    <tbody>
                        <tr><td class="border p-2 font-mono">name</td><td class="border p-2">Text</td><td class="border p-2">Nama Kategori Baru (Cth: <code>Snack</code>)</td></tr>
                    </tbody>
                </table>
            </div>

            <div class="bg-white p-4 rounded shadow-sm">
                <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded font-bold">POST</span> 
                <code class="text-pink-600 font-semibold ml-2">/category/delete</code>
                <p class="text-sm text-gray-600 mt-1">Menghapus kategori (Gagal jika masih dipakai oleh produk).</p>
                <table class="w-full text-left text-sm border-collapse bg-white rounded mt-3">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700"><th class="border p-2">Key (form-data)</th><th class="border p-2">Type</th><th class="border p-2">Keterangan</th></tr>
                    </thead>
                    <tbody>
                        <tr><td class="border p-2 font-mono">category_id</td><td class="border p-2">Text</td><td class="border p-2">ID Kategori</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 4. Kelola Pesanan -->
        <div class="mb-8 border-l-4 border-emerald-600 bg-gray-50 p-5 rounded-r-lg shadow-sm">
            <h2 class="text-xl font-bold text-emerald-800 mb-3">4. Kelola Pesanan</h2>
            
            <div class="mb-4 bg-white p-4 rounded shadow-sm">
                <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded font-bold">POST</span> 
                <code class="text-pink-600 font-semibold ml-2">/order/list</code>
                <p class="text-sm text-gray-600 mt-1">Menampilkan daftar semua pesanan masuk dari pelanggan.</p>
            </div>

            <div class="mb-4 bg-white p-4 rounded shadow-sm">
                <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded font-bold">POST</span> 
                <code class="text-pink-600 font-semibold ml-2">/order/detail</code>
                <p class="text-sm text-gray-600 mt-1">Menampilkan rincian pesanan dan informasi pelanggan.</p>
                <table class="w-full text-left text-sm border-collapse bg-white rounded mt-3">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700"><th class="border p-2">Key (form-data)</th><th class="border p-2">Type</th><th class="border p-2">Keterangan</th></tr>
                    </thead>
                    <tbody>
                        <tr><td class="border p-2 font-mono">order_id</td><td class="border p-2">Text</td><td class="border p-2">ID Pesanan</td></tr>
                    </tbody>
                </table>
            </div>

            <div class="bg-white p-4 rounded shadow-sm">
                <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded font-bold">POST</span> 
                <code class="text-pink-600 font-semibold ml-2">/order/update-status</code>
                <p class="text-sm text-gray-600 mt-1">Mengubah status pesanan masuk.</p>
                <table class="w-full text-left text-sm border-collapse bg-white rounded mt-3">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700"><th class="border p-2">Key (form-data)</th><th class="border p-2">Type</th><th class="border p-2">Keterangan</th></tr>
                    </thead>
                    <tbody>
                        <tr><td class="border p-2 font-mono">order_id</td><td class="border p-2">Text</td><td class="border p-2">ID Pesanan</td></tr>
                        <tr><td class="border p-2 font-mono">status</td><td class="border p-2">Text</td><td class="border p-2"><code>Diproses</code>, <code>Siap</code>, atau <code>Selesai</code></td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 5. Laporan & Profil Admin -->
        <div class="border-l-4 border-emerald-600 bg-gray-50 p-5 rounded-r-lg shadow-sm">
            <h2 class="text-xl font-bold text-emerald-800 mb-3">5. Laporan & Profil Admin</h2>
            
            <div class="mb-4 bg-white p-4 rounded shadow-sm">
                <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded font-bold">POST</span> 
                <code class="text-pink-600 font-semibold ml-2">/report/summary</code>
                <p class="text-sm text-gray-600 mt-1">Menampilkan ringkasan laporan penjualan dan menu terlaris.</p>
            </div>

            <div class="mb-4 bg-white p-4 rounded shadow-sm">
                <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded font-bold">POST</span> 
                <code class="text-pink-600 font-semibold ml-2">/profile/get</code>
                <p class="text-sm text-gray-600 mt-1">Mengambil data profil akun admin yang aktif.</p>
                <table class="w-full text-left text-sm border-collapse bg-white rounded mt-3">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700"><th class="border p-2">Key (form-data)</th><th class="border p-2">Type</th><th class="border p-2">Keterangan</th></tr>
                    </thead>
                    <tbody>
                        <tr><td class="border p-2 font-mono">admin_id</td><td class="border p-2">Text</td><td class="border p-2">ID Admin (Cth: <code>1</code>)</td></tr>
                    </tbody>
                </table>
            </div>

            <div class="bg-white p-4 rounded shadow-sm">
                <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded font-bold">POST</span> 
                <code class="text-pink-600 font-semibold ml-2">/profile/update</code>
                <p class="text-sm text-gray-600 mt-1">Memperbarui nama panggilan (nickname) admin.</p>
                <table class="w-full text-left text-sm border-collapse bg-white rounded mt-3">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700"><th class="border p-2">Key (form-data)</th><th class="border p-2">Type</th><th class="border p-2">Keterangan</th></tr>
                    </thead>
                    <tbody>
                        <tr><td class="border p-2 font-mono">admin_id</td><td class="border p-2">Text</td><td class="border p-2">ID Admin (Cth: <code>1</code>)</td></tr>
                        <tr><td class="border p-2 font-mono">nickname</td><td class="border p-2">Text</td><td class="border p-2">Nickname baru (Cth: <code>Super Admin</code>)</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>
</html>