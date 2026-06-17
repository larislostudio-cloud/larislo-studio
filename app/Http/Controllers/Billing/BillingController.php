<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use App\Models\CreditPackage;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Cek dan berikan kredit gratis harian
        if ($user->grantDailyFreeCredits()) {
            session()->flash('status', 'Anda mendapatkan 3 Kredit Gratis hari ini!');
        }

        $packages = CreditPackage::where('is_active', true)->get();

        return view('billing.index', compact('packages'));
    }

    public function buy(Request $request, $packageId)
    {
        $package = CreditPackage::findOrFail($packageId);

        // Arahkan ke Midtrans
        return app(MidtransController::class)->chargeCredits($package);
    }
}
