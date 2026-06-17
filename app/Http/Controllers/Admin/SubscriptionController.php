<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $plans = Subscription::all();
        return view('admin.subscriptions.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.subscriptions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|integer',
            'ai_credits_limit' => 'required|integer',
            'scheduler_enabled' => 'boolean'
        ]);

        Subscription::create($request->all());

        return redirect()->route('admin.subscriptions.index')->with('success', 'Plan created.');
    }

    public function edit(Subscription $subscription)
    {
        return view('admin.subscriptions.edit', compact('subscription'));
    }

    public function update(Request $request, Subscription $subscription)
    {
        $subscription->update($request->all());
        return redirect()->route('admin.subscriptions.index')->with('success', 'Plan updated.');
    }
}
