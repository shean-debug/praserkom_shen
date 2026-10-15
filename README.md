# Ticket Box — Sistem Pemesanan Tiket Konser / Event Musik

Aplikasi web pemesanan tiket konser dan event berbasis **Laravel**, dibuat untuk tugas Pra-Serkom.
Pelanggan dapat melihat katalog event, memilih jumlah tiket, lalu checkout. Admin dapat melihat rekap pesanan dan mengelola data event beserta poster.

**Dibuat oleh:** Sheanna Devika Alea

## Fitur

### Pelanggan (tanpa login)
- Melihat katalog event beserta poster, kategori, dan harga tiket.
- Filter event berdasarkan kategori: Musik, Festival, Seminar.
- Memilih jumlah tiket per event (0–10).
- Mengisi nama dan email, lalu checkout dengan konfirmasi pesanan.

### Admin (wajib login)
- Dashboard rekap pesanan masuk beserta rincian tiket dan total harga.
- Mengubah status pesanan: Pending, Confirmed, Cancelled.
- CRUD event: tambah, ubah, hapus, dan upload poster.
- Event yang sudah memiliki pesanan tidak dapat dihapus.

## Teknologi
- PHP 8.2 dan Laravel 12
- MySQL (XAMPP)
- Laravel Breeze (autentikasi)
- Tailwind CSS
- Vite dan Node.js

## Struktur Database (`db_ticket_konser`)

| Tabel | Kolom utama |
|---|---|
| `events` | id, title, category (Musik/Festival/Seminar), ticket_price, description, image, timestamps |
| `orders` | id, customer_name, customer_email, total_price, status (Pending/Confirmed/Cancelled), timestamps |
| `order_details` | id, order_id (FK orders), event_id (FK events), quantity, subtotal, timestamps |

Relasi: satu `orders` memiliki banyak `order_details`, dan satu `events` dapat muncul di banyak `order_details`.

## Cara Instalasi

1. **Persyaratan:** PHP 8.2+, Composer, Node.js, dan MySQL (XAMPP). Aktifkan Apache dan MySQL.
2. **Clone project**
   ```bash
   git clone https://github.com/username/praserkom_nama.git
   cd praserkom_nama
   ```
3. **Install dependensi**
   ```bash
   composer install
   npm install
   ```
4. **Siapkan file environment**
   ```bash
   copy .env.example .env
   php artisan key:generate
   ```
5. **Buat database** bernama `db_ticket_konser` di phpMyAdmin, lalu atur `.env`:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=db_ticket_konser
   DB_USERNAME=root
   DB_PASSWORD=
   ```
6. **Migrasi dan seeder**
   ```bash
   php artisan migrate --seed
   ```
7. **Link storage** (agar poster dapat tampil)
   ```bash
   php artisan storage:link
   ```
8. **Build aset**
   ```bash
   npm run build
   ```
9. **Jalankan aplikasi**
   ```bash
   php artisan serve
   ```
   Buka `http://127.0.0.1:8000`.

## Akun Admin (dari seeder)
- Email: `admin@gmail.com`
- Password: `admin12345`

## Alur Penggunaan
1. Pelanggan membuka halaman utama (`/`), memilih event dan jumlah tiket, mengisi nama dan email, lalu klik **Checkout**.
2. Admin login melalui **Login Admin**, lalu membuka **Dashboard** untuk melihat pesanan masuk dan mengubah statusnya.
3. Admin membuka **Kelola Event** untuk menambah, mengubah, atau menghapus event dan poster.

## Logika Transaksi
Saat checkout, data disimpan ke `orders` dan `order_details` menggunakan `DB::beginTransaction()`. Jika salah satu penyimpanan gagal, seluruh proses dibatalkan dengan `DB::rollBack()`. Harga tiket diambil dari database, bukan dari input form, sehingga tidak dapat dimanipulasi pengguna.

## Struktur Penting
- `app/Models` — Event, Order, OrderDetail
- `app/Http/Controllers` — EventController, OrderController
- `database/migrations` — struktur tabel
- `database/seeders` — akun admin dan data event contoh
- `resources/views/customer` — halaman pelanggan
- `resources/views/admin/events` — halaman kelola event
- `routes/web.php` — daftar route

## Catatan
- Gunakan `http://127.0.0.1:8000`, bukan `http://localhost` (yang menampilkan halaman XAMPP).
- Jika poster tidak tampil, jalankan `php artisan storage:link`.
- Jika tampilan tidak rapi, pastikan `npm run build` sudah dijalankan atau `npm run dev` sedang berjalan.
