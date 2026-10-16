<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumentasi API - EZPICK Backend</title>
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
                <h1 class="text-xl font-bold tracking-wider text-emerald-300">EZPICK API</h1>
                <p class="text-xs text-emerald-400 mt-1">Panduan Dokumentasi Backend v1.0</p>
            </div>
            <nav class="flex-1 overflow-y-auto p-4 space-y-2 text-sm">
                <a href="#auth" class="block px-3 py-2 rounded hover:bg-emerald-800 transition">1. Autentikasi (Auth)</a>
                <a href="#categories" class="block px-3 py-2 rounded hover:bg-emerald-800 transition">2. Kategori</a>
                <a href="#products" class="block px-3 py-2 rounded hover:bg-emerald-800 transition">3. Produk & Pencarian</a>
                <a href="#cart" class="block px-3 py-2 rounded hover:bg-emerald-800 transition">4. Keranjang (Cart)</a>
                <a href="#order" class="block px-3 py-2 rounded hover:bg-emerald-800 transition">5. Pesanan & Checkout</a>
                <a href="#review" class="block px-3 py-2 rounded hover:bg-emerald-800 transition">6. Ulasan (Review)</a>
                <a href="#notification" class="block px-3 py-2 rounded hover:bg-emerald-800 transition">7. Notifikasi</a>
                <a href="#favorite" class="block px-3 py-2 rounded hover:bg-emerald-800 transition">8. Favorit</a>
                <a href="#user" class="block px-3 py-2 rounded hover:bg-emerald-800 transition">9. Profil Pengguna</a>
            </nav>
            <div class="p-4 border-t border-emerald-800 text-xs text-emerald-400 text-center">
                Base URL: <code class="bg-emerald-950 px-1 py-0.5 rounded text-emerald-200">http://localhost/backend_toko_online/</code>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-6 md:p-10">
            <div class="max-w-4xl mx-auto space-y-12">
                
                <!-- Header Banner -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h2 class="text-2xl font-bold text-gray-900">Dokumentasi API Backend Toko Online</h2>
                    <p class="text-gray-600 mt-1 text-sm">Seluruh endpoint di bawah ini menerima request berformat <span class="font-semibold text-emerald-600">POST / GET</span> dengan payload <span class="font-semibold text-emerald-600">form-data</span> atau x-www-form-urlencoded.</p>
                </div>

                <!-- 1. AUTH -->
                <section id="auth" class="space-y-4">
                    <h3 class="text-xl font-bold text-emerald-900 border-b pb-2">1. Autentikasi (Auth)</h3>
                    
                    <!-- Register -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">POST</span>
                            <code class="text-sm font-mono text-gray-700">/auth/register</code>
                        </div>
                        <p class="text-sm text-gray-600">Mendaftarkan akun pengguna baru ke dalam sistem.</p>
                        <div>
                            <h4 class="text-xs font-bold uppercase text-gray-500 mb-1">Parameter (form-data):</h4>
                            <ul class="text-xs space-y-1 text-gray-700 font-mono bg-gray-50 p-3 rounded border">
                                <li>username (string, wajib)</li>
                                <li>email (string, wajib)</li>
                                <li>password (string, wajib)</li>
                                <li>no_tlp (string, wajib)</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Login -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">POST</span>
                            <code class="text-sm font-mono text-gray-700">/auth/login</code>
                        </div>
                        <p class="text-sm text-gray-600">Melakukan autentikasi masuk pengguna berdasarkan email dan password.</p>
                        <div>
                            <h4 class="text-xs font-bold uppercase text-gray-500 mb-1">Parameter (form-data):</h4>
                            <ul class="text-xs space-y-1 text-gray-700 font-mono bg-gray-50 p-3 rounded border">
                                <li>email (string, wajib)</li>
                                <li>password (string, wajib)</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- 2. CATEGORIES -->
                <section id="categories" class="space-y-4">
                    <h3 class="text-xl font-bold text-emerald-900 border-b pb-2">2. Kategori</h3>
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-1 rounded">GET / POST</span>
                            <code class="text-sm font-mono text-gray-700">/categories/list</code>
                        </div>
                        <p class="text-sm text-gray-600">Mengambil daftar seluruh kategori beserta sampel gambar untuk shortcut di Beranda.</p>
                    </div>
                </section>

                <!-- 3. PRODUCTS -->
                <section id="products" class="space-y-4">
                    <h3 class="text-xl font-bold text-emerald-900 border-b pb-2">3. Produk & Pencarian</h3>
                    
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-1 rounded">GET</span>
                            <code class="text-sm font-mono text-gray-700">/products</code>
                        </div>
                        <p class="text-sm text-gray-600">Menampilkan seluruh daftar produk makanan dan minuman.</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">POST</span>
                            <code class="text-sm font-mono text-gray-700">/products/recommendations</code>
                        </div>
                        <p class="text-sm text-gray-600">Menampilkan daftar produk Best Seller dan Harga Terjangkau (Screen 05).</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">POST</span>
                            <code class="text-sm font-mono text-gray-700">/products/category</code>
                        </div>
                        <p class="text-sm text-gray-600">Menampilkan produk berdasarkan kategori tertentu beserta status stok (Screen 06).</p>
                        <div>
                            <h4 class="text-xs font-bold uppercase text-gray-500 mb-1">Parameter (form-data):</h4>
                            <ul class="text-xs space-y-1 text-gray-700 font-mono bg-gray-50 p-3 rounded border">
                                <li>category_id (int, wajib)</li>
                            </ul>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">POST</span>
                            <code class="text-sm font-mono text-gray-700">/products/search-advanced</code>
                        </div>
                        <p class="text-sm text-gray-600">Pencarian menu dengan filter tab (Semua, Makanan, Minuman, Promo) dan rekomendasi "Mungkin kamu suka" (Screen 07).</p>
                        <div>
                            <h4 class="text-xs font-bold uppercase text-gray-500 mb-1">Parameter (form-data):</h4>
                            <ul class="text-xs space-y-1 text-gray-700 font-mono bg-gray-50 p-3 rounded border">
                                <li>keyword (string)</li>
                                <li>filter (string: Semua / Makanan / Minuman / Promo)</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- 4. CART -->
                <section id="cart" class="space-y-4">
                    <h3 class="text-xl font-bold text-emerald-900 border-b pb-2">4. Keranjang (Cart)</h3>
                    
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">POST</span>
                            <code class="text-sm font-mono text-gray-700">/cart/add</code>
                        </div>
                        <p class="text-sm text-gray-600">Menambahkan produk ke keranjang belanja beserta catatan item.</p>
                        <div>
                            <h4 class="text-xs font-bold uppercase text-gray-500 mb-1">Parameter (form-data):</h4>
                            <ul class="text-xs space-y-1 text-gray-700 font-mono bg-gray-50 p-3 rounded border">
                                <li>user_id (int, wajib)</li>
                                <li>product_id (int, wajib)</li>
                                <li>quantity (int, wajib)</li>
                                <li>notes (string, opsional - cth: "pedas")</li>
                            </ul>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">POST</span>
                            <code class="text-sm font-mono text-gray-700">/cart/list</code>
                        </div>
                        <p class="text-sm text-gray-600">Menampilkan daftar isi keranjang belanja pengguna (Screen 09).</p>
                        <div>
                            <h4 class="text-xs font-bold uppercase text-gray-500 mb-1">Parameter (form-data):</h4>
                            <ul class="text-xs space-y-1 text-gray-700 font-mono bg-gray-50 p-3 rounded border">
                                <li>user_id (int, wajib)</li>
                            </ul>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">POST</span>
                            <code class="text-sm font-mono text-gray-700">/cart/update-qty</code>
                        </div>
                        <p class="text-sm text-gray-600">Mengubah kuantitas item keranjang langsung menggunakan tombol `+` / `-` (Screen 09).</p>
                        <div>
                            <h4 class="text-xs font-bold uppercase text-gray-500 mb-1">Parameter (form-data):</h4>
                            <ul class="text-xs space-y-1 text-gray-700 font-mono bg-gray-50 p-3 rounded border">
                                <li>cart_id (int, wajib)</li>
                                <li>quantity (int, wajib - jika 0 item akan dihapus)</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- 5. ORDER -->
                <section id="order" class="space-y-4">
                    <h3 class="text-xl font-bold text-emerald-900 border-b pb-2">5. Pesanan & Checkout</h3>
                    
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">POST</span>
                            <code class="text-sm font-mono text-gray-700">/order/checkout</code>
                        </div>
                        <p class="text-sm text-gray-600">Memproses transaksi pembelian lengkap dengan waktu pengambilan, lokasi resto, metode pembayaran (Gopay, DANA, BCA, dll), uang muka, dan sisa kekurangan (Screen 10 & 11).</p>
                        <div>
                            <h4 class="text-xs font-bold uppercase text-gray-500 mb-1">Parameter (form-data):</h4>
                            <ul class="text-xs space-y-1 text-gray-700 font-mono bg-gray-50 p-3 rounded border">
                                <li>user_id (int, wajib)</li>
                                <li>product_id (int, wajib)</li>
                                <li>quantity (int, wajib)</li>
                                <li>pickup_time_type (string: "Secepatnya" / "Pilih jam sendiri")</li>
                                <li>pickup_time_value (string: cth "12:30")</li>
                                <li>pickup_location (string: cth "Resto Pusat - Pandanaran")</li>
                                <li>payment_method (string: cth "Gopay", "DANA", "BCA", "QRIS", dll)</li>
                                <li>account_name (string: Atas Nama)</li>
                                <li>down_payment (decimal: Uang Muka)</li>
                                <li>notes (string)</li>
                            </ul>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">POST</span>
                            <code class="text-sm font-mono text-gray-700">/order/receipt</code>
                        </div>
                        <p class="text-sm text-gray-600">Menampilkan struk transaksi berhasil lengkap dengan nomor antrian dan rincian pembayaran (Screen 12).</p>
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
                            <code class="text-sm font-mono text-gray-700">/order/history</code>
                        </div>
                        <p class="text-sm text-gray-600">Menampilkan riwayat daftar pesanan pengguna (Screen 14).</p>
                        <div>
                            <h4 class="text-xs font-bold uppercase text-gray-500 mb-1">Parameter (form-data):</h4>
                            <ul class="text-xs space-y-1 text-gray-700 font-mono bg-gray-50 p-3 rounded border">
                                <li>user_id (int, wajib)</li>
                            </ul>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">POST</span>
                            <code class="text-sm font-mono text-gray-700">/order/detail</code>
                        </div>
                        <p class="text-sm text-gray-600">Menampilkan detail pesanan, status pelacakan (Diproses, Siap, Selesai), dan rincian pembayaran (Screen 15).</p>
                        <div>
                            <h4 class="text-xs font-bold uppercase text-gray-500 mb-1">Parameter (form-data):</h4>
                            <ul class="text-xs space-y-1 text-gray-700 font-mono bg-gray-50 p-3 rounded border">
                                <li>order_id (int, wajib)</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- 6. REVIEW -->
                <section id="review" class="space-y-4">
                    <h3 class="text-xl font-bold text-emerald-900 border-b pb-2">6. Ulasan (Review)</h3>
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">POST</span>
                            <code class="text-sm font-mono text-gray-700">/review/create</code>
                        </div>
                        <p class="text-sm text-gray-600">Mengirim ulasan produk/pesanan berupa rating bintang 1-5, komentar, dan tag kesan (Screen 13).</p>
                        <div>
                            <h4 class="text-xs font-bold uppercase text-gray-500 mb-1">Parameter (form-data):</h4>
                            <ul class="text-xs space-y-1 text-gray-700 font-mono bg-gray-50 p-3 rounded border">
                                <li>order_id (int, wajib)</li>
                                <li>user_id (int, wajib)</li>
                                <li>product_id (int, wajib)</li>
                                <li>rating (int: 1 s/d 5)</li>
                                <li>comment (string)</li>
                                <li>tags (string: cth "Rasa,Porsi")</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- 7. NOTIFICATION -->
                <section id="notification" class="space-y-4">
                    <h3 class="text-xl font-bold text-emerald-900 border-b pb-2">7. Notifikasi</h3>
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">POST</span>
                            <code class="text-sm font-mono text-gray-700">/notification/list</code>
                        </div>
                        <p class="text-sm text-gray-600">Menampilkan daftar pemberitahuan pesanan pengguna (Screen 16).</p>
                        <div>
                            <h4 class="text-xs font-bold uppercase text-gray-500 mb-1">Parameter (form-data):</h4>
                            <ul class="text-xs space-y-1 text-gray-700 font-mono bg-gray-50 p-3 rounded border">
                                <li>user_id (int, wajib)</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- 8. FAVORITE -->
                <section id="favorite" class="space-y-4">
                    <h3 class="text-xl font-bold text-emerald-900 border-b pb-2">8. Favorit</h3>
                    
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">POST</span>
                            <code class="text-sm font-mono text-gray-700">/favorite/list</code>
                        </div>
                        <p class="text-sm text-gray-600">Menampilkan daftar menu favorit dengan filter kategori (Semua, Makanan, Minuman) (Screen 17).</p>
                        <div>
                            <h4 class="text-xs font-bold uppercase text-gray-500 mb-1">Parameter (form-data):</h4>
                            <ul class="text-xs space-y-1 text-gray-700 font-mono bg-gray-50 p-3 rounded border">
                                <li>user_id (int, wajib)</li>
                                <li>category (string: "Semua" / "Makanan" / "Minuman")</li>
                            </ul>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">POST</span>
                            <code class="text-sm font-mono text-gray-700">/favorite/add</code>
                        </div>
                        <p class="text-sm text-gray-600">Menambahkan produk ke daftar favorit.</p>
                        <div>
                            <h4 class="text-xs font-bold uppercase text-gray-500 mb-1">Parameter (form-data):</h4>
                            <ul class="text-xs space-y-1 text-gray-700 font-mono bg-gray-50 p-3 rounded border">
                                <li>user_id (int, wajib)</li>
                                <li>product_id (int, wajib)</li>
                            </ul>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">POST</span>
                            <code class="text-sm font-mono text-gray-700">/favorite/remove</code>
                        </div>
                        <p class="text-sm text-gray-600">Menghapus produk dari daftar favorit.</p>
                        <div>
                            <h4 class="text-xs font-bold uppercase text-gray-500 mb-1">Parameter (form-data):</h4>
                            <ul class="text-xs space-y-1 text-gray-700 font-mono bg-gray-50 p-3 rounded border">
                                <li>user_id (int, wajib)</li>
                                <li>product_id (int, wajib)</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- 9. USER PROFILE -->
                <section id="user" class="space-y-4">
                    <h3 class="text-xl font-bold text-emerald-900 border-b pb-2">9. Profil Pengguna</h3>
                    
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">POST</span>
                            <code class="text-sm font-mono text-gray-700">/user/profile</code>
                        </div>
                        <p class="text-sm text-gray-600">Mengambil data profil lengkap pengguna (Screen 18).</p>
                        <div>
                            <h4 class="text-xs font-bold uppercase text-gray-500 mb-1">Parameter (form-data):</h4>
                            <ul class="text-xs space-y-1 text-gray-700 font-mono bg-gray-50 p-3 rounded border">
                                <li>user_id (int, wajib)</li>
                            </ul>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">POST</span>
                            <code class="text-sm font-mono text-gray-700">/user/update</code>
                        </div>
                        <p class="text-sm text-gray-600">Memperbarui nickname (username) dan upload foto avatar baru (Screen 19).</p>
                        <div>
                            <h4 class="text-xs font-bold uppercase text-gray-500 mb-1">Parameter (form-data):</h4>
                            <ul class="text-xs space-y-1 text-gray-700 font-mono bg-gray-50 p-3 rounded border">
                                <li>user_id (int, wajib)</li>
                                <li>username (string, wajib - Nickname baru)</li>
                                <li>avatar (file image, opsional - Ganti foto profil)</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <footer class="text-center py-8 text-xs text-gray-400 border-t">
                    EZPICK Backend API Documentation &bull; Ready for Postman Testing
                </footer>

            </div>
        </main>
    </div>

</body>
</html>