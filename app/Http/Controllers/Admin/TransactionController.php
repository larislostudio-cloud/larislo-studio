<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\WhatsApp\WhatsAppService; // Pastikan import ini ada
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        // HAPUS 'creditPackage' dari with() karena relasi tersebut belum didefinisikan dengan benar
        $transactions = Transaction::with('user')->latest()->paginate(15);

        return view('admin.transactions.index', compact('transactions'));
    }

    public function validatePayment(Request $request, Transaction $transaction, WhatsAppService $waService)
    {
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaksi ini sudah diproses.');
        }

        // 1. Update Status
        $transaction->update(['status' => 'paid']);

        // 2. Add Credits
        $transaction->user->addCredits($transaction->amount);

        // 3. Kirim Notif WA (Opsional, pastikan WhatsAppService sudah dikonfigurasi)
        try {
            $msg = "✅ *PEMBAYARAN TERVERALIDASI*\n\nKredit: +{$transaction->amount}\nStatus: Sukses";
            $waService->notifyAdmin($msg);
        } catch (\Exception $e) {
            // Abaikan error WA jika gagal
        }

        return back()->with('success', 'Pembayaran berhasil divalidasi dan kredit telah ditambahkan.');
    }

    public function reject(Request $request, Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaksi ini sudah diproses.');
        }

        $transaction->update(['status' => 'rejected']);

        return back()->with('success', 'Transaksi telah ditolak.');
    }
}
