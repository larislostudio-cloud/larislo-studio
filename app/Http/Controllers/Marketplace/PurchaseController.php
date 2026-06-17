<?php

namespace App\Http\Controllers\Marketplace;

use App\Http\Controllers\Controller;
use App\Models\Template;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function buy(Request $request, $id)
    {
        $user = auth()->user();
        $template = Template::findOrFail($id);

        // Cek jika sudah punya
        if ($user->purchases()->where('template_id', $id)->exists()) {
            return back()->with('error', 'Anda sudah memiliki template ini.');
        }

        // Cek Kredit (Asumsi harga template dalam kredit, atau konversi rupiah ke kredit)
        // Di sini saya asumsikan 1 Template = 10 Kredit (atau bisa $template->price_credits)
        $creditCost = 10;

        if (!$user->hasCredits($creditCost)) {
            return back()->with('error', "Kredit tidak cukup untuk membeli template ini. Butuh {$creditCost} Kredit.");
        }

        // Proses Transaksi
        $user->deductCredits($creditCost);

        // Catat Pembelian
        Purchase::create([
            'user_id' => $user->id,
            'template_id' => $template->id,
            'price' => $creditCost, // Simpan harga dalam kredit
        ]);

        return redirect()->route('marketplace.library')->with('success', 'Pembelian berhasil! Template siap diunduh.');
    }

    // ... method library & download tetap sama
}
