<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\StoreReceiptRequest;
use App\Models\Receipt;
use App\Models\TenantBill;
use App\Services\Files\PhotoStorage;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        return view('tenant.payments.index', [
            'receipts' => Receipt::with('tenantBill')->where('user_id', $request->user()->id)->latest()->paginate(12),
        ]);
    }

    public function create(Request $request)
    {
        return view('tenant.payments.create', [
            'bills' => TenantBill::where('user_id', $request->user()->id)->latest()->get(),
        ]);
    }

    public function store(StoreReceiptRequest $request, PhotoStorage $storage)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $data['image_path'] = $storage->store($request->file('receipt'), 'receipts');
        unset($data['receipt']);

        $receipt = Receipt::create($data);

        return redirect()->route('tenant.payments.show', $receipt)->with('status', 'Payment receipt submitted.');
    }

    public function show(Request $request, Receipt $payment)
    {
        abort_unless($payment->user_id === $request->user()->id, 403);

        return view('tenant.payments.show', ['receipt' => $payment->load('tenantBill.billingPeriod')]);
    }
}
