<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\StoreBillingPeriodRequest;
use App\Http\Requests\Manager\UpdateBillingPeriodRequest;
use App\Models\BillingPeriod;

class BillingPeriodController extends Controller
{
    public function index()
    {
        return view('manager.billing-periods.index', [
            'periods' => BillingPeriod::withCount('tenantBills')->latest('starts_at')->paginate(12),
        ]);
    }

    public function create()
    {
        return view('manager.billing-periods.create');
    }

    public function store(StoreBillingPeriodRequest $request)
    {
        BillingPeriod::create($request->validated() + ['is_closed' => $request->boolean('is_closed')]);

        return redirect()->route('manager.billing-periods.index')->with('status', 'Billing period created.');
    }

    public function show(BillingPeriod $billingPeriod)
    {
        return view('manager.billing-periods.show', [
            'period' => $billingPeriod->load('tenantBills.tenant'),
        ]);
    }

    public function edit(BillingPeriod $billingPeriod)
    {
        return view('manager.billing-periods.edit', ['period' => $billingPeriod]);
    }

    public function update(UpdateBillingPeriodRequest $request, BillingPeriod $billingPeriod)
    {
        $billingPeriod->update($request->validated() + ['is_closed' => $request->boolean('is_closed')]);

        return redirect()->route('manager.billing-periods.show', $billingPeriod)->with('status', 'Billing period updated.');
    }

    public function destroy(BillingPeriod $billingPeriod)
    {
        $billingPeriod->delete();

        return redirect()->route('manager.billing-periods.index')->with('status', 'Billing period deleted.');
    }
}
