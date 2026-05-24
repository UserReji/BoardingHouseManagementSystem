<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\GCashAccount;

class GCashController extends Controller
{
    public function show()
    {
        return view('tenant.gcash.show', [
            'account' => GCashAccount::where('is_active', true)->latest()->first(),
        ]);
    }
}
