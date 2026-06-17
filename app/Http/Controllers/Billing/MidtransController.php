<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use App\Models\CreditPackage;
use App\Models\Transaction; // Import Model Transaction
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use App\Services\WhatsAppService; // Import WhatsAppService

class MidtransController extends Controller
{
    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function chargeCredits(CreditPackage $package)
    {
        $user = auth()->user();
        $orderId = 'CRED-' . uniqid();

        // ==========================================
        // TAMBAHAN: Simpan ke Database sebagai PENDING
        // Ini diperlukan agar callback bisa menemukan transaksi ini nanti
        // ==========================================
        Transaction::create([
            'user_id' => $user->id,
            'order_id' => $orderId,
            'amount' => $package->total_credits, // Jumlah kredit
            'price' => $package->price,          // Harga uang
            'status' => 'pending',
            'payment_type' => 'midtrans',
        ]);

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $package->price,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'item_details' => [[
                'id' => $package->id,
                'price' => $package->price,
                'quantity' => 1,
                'name' => $package->name,
            ]],
            // Custom field tidak wajib lagi karena sudah disimpan di DB,
            // tapi bisa dipertahankan untuk cadangan.
            'custom_field1' => $user->id,
            'custom_field2' => $package->total_credits,
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return view('billing.payment', compact('snapToken', 'package', 'orderId'));

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    public function callback(Request $request, WhatsAppService $waService)
    {
        // 1. Verifikasi Signature Key (WAJIB untuk keamanan)
        $serverKey = config('services.midtrans.server_key');
        $hashed = hash("sha512",
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        if ($hashed !== $request->signature_key) {
            return response()->json(['message' => 'Invalid Signature'], 403);
        }

        // 2. Logika sukses pembayaran
        if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {

        $transaction = Transaction::where('order_id', $request->order_id)->first();

        if ($transaction && $transaction->status == 'pending') {

            // 1. Update Status DB
            $transaction->update(['status' => 'paid']);

            // 2. Tambah Kredit ke User
            $transaction->user->addCredits($transaction->amount);

            // 3. Kirim Notifikasi WhatsApp ke Admin
            try {
                // Format pesan yang lebih informatif
                $msg = "🎉 *PEMBAYARAN DITERIMA*\n\n"
                     . "👤 *User:* {$transaction->user->name} ({$transaction->user->email})\n"
                     . "🆔 *Order ID:* {$transaction->order_id}\n"
                     . "💎 *Total Kredit:* +{$transaction->amount}\n"
                     . "💰 *Nominal:* Rp " . number_format($transaction->price, 0, ',', '.') . "\n"
                     . "💳 *Metode:* Midtrans\n"
                     . "⏰ *Waktu:* " . now()->format('d M Y H:i') . "\n\n"
                     . "Status: *PAID ✅*";

                $waService->notifyAdmin($msg);
            } catch (\Exception $e) {
                \Log::error('Gagal kirim notif WA ke Admin: ' . $e->getMessage());
            }
        }
    }

        return response()->json(['status' => 'ok']);
    }
}
