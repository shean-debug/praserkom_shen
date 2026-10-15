<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Halaman publik: katalog konser
    // Mengambil semua event lalu mengirimnya ke view customer/index.blade.php
    public function index()
    {
        $events = Event::all();
        return view('customer.index', compact('events'));
    }

    // Checkout: simpan orders + order_details dalam satu transaksi
    public function store(Request $request)
    {
        // Validasi: nama & email wajib, items wajib array,
        // jumlah tiket tiap event boleh kosong, harus bilangan bulat 0-10
        $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'items'          => 'required|array',
            'items.*'        => 'nullable|integer|min:0|max:10',
        ]);

        // Ambil hanya event dengan jumlah tiket > 0
        $orderedItems = array_filter($request->items, fn ($qty) => $qty > 0);

        // Kalau tidak ada tiket yang dipilih, kembali ke form (input lama tetap terisi)
        if (empty($orderedItems)) {
            return back()->withInput()->with('error', 'Pilih minimal satu tiket event!');
        }

        // Mulai transaksi: jika ada satu langkah gagal, semua dibatalkan
        DB::beginTransaction();
        try {
            // Simpan header pesanan dulu, total sementara 0
            $order = Order::create([
                'customer_name'  => $request->customer_name,
                'customer_email' => $request->customer_email,
                'total_price'    => 0,
                'status'         => 'Pending',
            ]);

            $totalPrice = 0;

            // Simpan tiap event yang dipesan ke order_details
            foreach ($orderedItems as $eventId => $quantity) {
                // Harga diambil dari database (bukan dari form) agar tidak bisa dimanipulasi
                $event = Event::findOrFail($eventId);
                $subtotal = $event->ticket_price * (int) $quantity;
                $totalPrice += $subtotal;

                OrderDetail::create([
                    'order_id' => $order->id,
                    'event_id' => $event->id,
                    'quantity' => (int) $quantity,
                    'subtotal' => $subtotal,
                ]);
            }

            // Update total harga setelah semua subtotal dijumlahkan
            $order->update(['total_price' => $totalPrice]);

            // Semua berhasil: simpan permanen ke database
            DB::commit();

            return redirect()->route('customer.index')
                ->with('success', 'Pesanan #' . $order->id . ' berhasil dibuat! Total: Rp ' . number_format($totalPrice, 0, ',', '.'));
        } catch (\Exception $e) {
            // Ada yang gagal: batalkan semua perubahan, tampilkan pesan error
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }

    // Dashboard admin: rekap semua pesanan
    // with('orderDetails.event') = eager loading, relasi diambil sekaligus agar query hemat
    public function adminDashboard()
    {
        $orders = Order::with('orderDetails.event')->latest()->get();
        return view('dashboard', compact('orders'));
    }

    // Ubah status pesanan (Pending / Confirmed / Cancelled)
    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:Pending,Confirmed,Cancelled']);
        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan #' . $order->id . ' berhasil diperbarui!');
    }
}
