<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dokumentasi API EZPICK - Backend PHP & MySQL</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 40px; background: #f9f9f9; }
        .container { max-width: 800px; background: #fff; padding: 40px; margin: auto; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { color: #0f5132; border-bottom: 2px solid #0f5132; padding-bottom: 10px; }
        h2 { color: #198754; margin-top: 30px; border-bottom: 1px solid #ddd; padding-bottom: 5px; }
        .endpoint { background: #f8f9fa; border-left: 4px solid #198754; padding: 15px; margin-bottom: 20px; border-radius: 4px; }
        .method { font-weight: bold; padding: 3px 8px; border-radius: 4px; color: #fff; font-size: 12px; }
        .post { background: #ffc107; color: #000; }
        .get { background: #0dcaf0; color: #000; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; margin-bottom: 10px; }
        th, td { border: 1px solid #dee2e6; padding: 8px 12px; text-align: left; font-size: 14px; }
        th { background-color: #e9ecef; }
        code { background: #e9ecef; padding: 2px 5px; border-radius: 4px; font-family: monospace; font-size: 13px; color: #d63384; }
        @media print {
            body { background: #fff; margin: 0; }
            .container { box-shadow: none; padding: 0; }
            .endpoint { break-inside: avoid; }
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Dokumentasi API EZPICK</h1>
    <p>Base URL: <code>http://localhost/ezpick-backend/</code></p>
    <p>Format Body Testing Postman: <strong>form-data</strong></p>

    <h2>1. Autentikasi (Auth)</h2>
    
    <div class="endpoint">
        <span class="method post">POST</span> <code>/auth/register</code>
        <p>Mendaftarkan akun pengguna baru.</p>
        <table>
            <tr><th>Key (form-data)</th><th>Type</th><th>Keterangan</th></tr>
            <tr><td>username</td><td>Text</td><td>Nama pengguna unik</td></tr>
            <tr><td>email</td><td>Text</td><td>Alamat email aktif</td></tr>
            <tr><td>password</td><td>Text</td><td>Kata sandi akun</td></tr>
            <tr><td>no_tlp</td><td>Text</td><td>Nomor telepon/WhatsApp</td></tr>
        </table>
    </div>

    <div class="endpoint">
        <span class="method post">POST</span> <code>/auth/login</code>
        <p>Masuk ke aplikasi menggunakan username/email dan password.</p>
        <table>
            <tr><th>Key (form-data)</th><th>Type</th><th>Keterangan</th></tr>
            <tr><td>username</td><td>Text</td><td>Username atau Email terdaftar</td></tr>
            <tr><td>password</td><td>Text</td><td>Kata sandi</td></tr>
        </table>
    </div>

    <h2>2. Produk & Menu</h2>

    <div class="endpoint">
        <span class="method get">GET</span> <code>/products</code>
        <p>Menampilkan seluruh daftar menu makanan dan minuman.</p>
    </div>

    <div class="endpoint">
        <span class="method get">GET</span> <code>/products/best-seller</code>
        <p>Menampilkan produk unggulan (Best Seller).</p>
    </div>

    <div class="endpoint">
        <span class="method post">POST</span> <code>/products/search</code>
        <p>Mencari menu berdasarkan kata kunci nama produk.</p>
        <table>
            <tr><th>Key (form-data)</th><th>Type</th><th>Keterangan</th></tr>
            <tr><td>keyword</td><td>Text</td><td>Kata kunci pencarian (cth: "Ayam")</td></tr>
        </table>
    </div>

    <div class="endpoint">
        <span class="method post">POST</span> <code>/products/recommendations</code>
        <p>Menampilkan halaman rekomendasi berisi Best Seller dan Harga Terjangkau.</p>
    </div>

    <div class="endpoint">
        <span class="method post">POST</span> <code>/products/category</code>
        <p>Menampilkan banner kategori dan daftar produk di dalamnya.</p>
        <table>
            <tr><th>Key (form-data)</th><th>Type</th><th>Keterangan</th></tr>
            <tr><td>category_id</td><td>Text</td><td>ID Kategori (cth: 1 untuk Promo Spesial)</td></tr>
        </table>
    </div>

    <h2>3. Keranjang Belanja (Cart)</h2>

    <div class="endpoint">
        <span class="method post">POST</span> <code>/cart/add</code>
        <p>Menambahkan produk ke keranjang belanja pengguna.</p>
        <table>
            <tr><th>Key (form-data)</th><th>Type</th><th>Keterangan</th></tr>
            <tr><td>user_id</td><td>Text</td><td>ID User yang sedang login</td></tr>
            <tr><td>product_id</td><td>Text</td><td>ID Produk yang dipilih</td></tr>
            <tr><td>quantity</td><td>Text</td><td>Jumlah kuantitas pesanan</td></tr>
        </table>
    </div>

    <div class="endpoint">
        <span class="method post">POST</span> <code>/cart/list</code>
        <p>Menampilkan daftar list produk di keranjang beserta total harga.</p>
        <table>
            <tr><th>Key (form-data)</th><th>Type</th><th>Keterangan</th></tr>
            <tr><td>user_id</td><td>Text</td><td>ID User</td></tr>
        </table>
    </div>

    <h2>4. Transaksi & Pembelian (Order/Checkout)</h2>

    <div class="endpoint">
        <span class="method post">POST</span> <code>/order/checkout</code>
        <p>Memproses pembelian pesanan produk.</p>
        <table>
            <tr><th>Key (form-data)</th><th>Type</th><th>Keterangan</th></tr>
            <tr><td>user_id</td><td>Text</td><td>ID User pembeli</td></tr>
            <tr><td>product_id</td><td>Text</td><td>ID Produk yang dibeli</td></tr>
            <tr><td>quantity</td><td>Text</td><td>Jumlah kuantitas (tombol +/-)</td></tr>
            <tr><td>order_type</td><td>Text</td><td>"Diambil" atau "Makan Di Tempat"</td></tr>
            <tr><td>dine_capacity</td><td>Text</td><td>"1 Orang", "2-4 Orang", "4++ Orang" (Opsional jika makan di tempat)</td></tr>
            <tr><td>notes</td><td>Text</td><td>Catatan pesanan dari pembeli</td></tr>
            <tr><td>payment_method</td><td>Text</td><td>Metode pembayaran (cth: "QRIS", "Cash")</td></tr>
        </table>
    </div>
</div>
</body>
</html>