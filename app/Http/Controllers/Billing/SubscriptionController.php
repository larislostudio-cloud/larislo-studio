<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Events\SubscriptionActivated;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function choosePlan($id)
    {
        $plan = Subscription::findOrFail($id);
        return redirect()->route('billing.pay', $plan->id);
    }

    public function activate(Request $request)
    {
        // Biasanya dipanggil setelah callback sukses
        $user = auth()->user();
        $planId = $request->plan_id;

        $user->update(['subscription_id' => $planId]);

        // Trigger Event
        SubscriptionActivated::dispatch($user);

        return redirect()->route('billing.index')->with('success', 'Paket berhasil diaktifkan!');
    }
}
