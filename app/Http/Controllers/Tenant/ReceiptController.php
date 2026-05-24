<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\StoreReceiptRequest;
use App\Models\Receipt;
use App\Models\TenantBill;
use App\Services\Files\PhotoStorage;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function index(Request $request)
    {
        return view('tenant.receipts.index', [
            'receipts' => Receipt::with('tenantBill')->where('user_id', $request->user()->id)->latest()->paginate(12),
        ]);
    }

    public function create(Request $request)
    {
        return view('tenant.receipts.create', [
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

        return redirect()->route('tenant.receipts.show', $receipt)->with('status', 'Receipt uploaded.');
    }

    public function show(Request $request, Receipt $receipt)
    {
        abort_unless($receipt->user_id === $request->user()->id, 403);

        return view('tenant.receipts.show', ['receipt' => $receipt->load('tenantBill.billingPeriod', 'reviewer')]);
    }
}
