<?php

namespace App\Http\Controllers\Manager;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\StoreTenantBillRequest;
use App\Http\Requests\Manager\UpdateTenantBillRequest;
use App\Models\BillingPeriod;
use App\Models\Room;
use App\Models\TenantBill;
use App\Models\User;
use App\Services\Billing\BillCalculator;

class TenantBillController extends Controller
{
    public function index()
    {
        return view('manager.tenant-bills.index', [
            'bills' => TenantBill::with('tenant', 'room', 'billingPeriod')->latest()->paginate(12),
        ]);
    }

    public function create()
    {
        return view('manager.tenant-bills.create', $this->formData());
    }

    public function store(StoreTenantBillRequest $request, BillCalculator $calculator)
    {
        $data = $request->validated();
        $data['status'] = $data['status'] ?? $calculator->statusFor($data);

        $bill = TenantBill::create($data);
        $calculator->syncStatus($bill);

        return redirect()->route('manager.tenant-bills.show', $bill)->with('status', 'Bill created.');
    }

    public function show(TenantBill $tenantBill)
    {
        return view('manager.tenant-bills.show', [
            'bill' => $tenantBill->load('tenant', 'room', 'billingPeriod', 'receipts'),
        ]);
    }

    public function edit(TenantBill $tenantBill)
    {
        return view('manager.tenant-bills.edit', $this->formData() + ['bill' => $tenantBill]);
    }

    public function update(UpdateTenantBillRequest $request, TenantBill $tenantBill, BillCalculator $calculator)
    {
        $tenantBill->update($request->validated());
        $calculator->syncStatus($tenantBill);

        return redirect()->route('manager.tenant-bills.show', $tenantBill)->with('status', 'Bill updated.');
    }

    public function destroy(TenantBill $tenantBill)
    {
        $tenantBill->delete();

        return redirect()->route('manager.tenant-bills.index')->with('status', 'Bill deleted.');
    }

    private function formData(): array
    {
        return [
            'tenants' => User::where('role', UserRole::Tenant)->orderBy('name')->get(),
            'rooms' => Room::orderBy('name')->get(),
            'periods' => BillingPeriod::latest('starts_at')->get(),
        ];
    }
}
