<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\UpdateGCashRequest;
use App\Models\GCashAccount;
use App\Services\Files\PhotoStorage;

class GCashController extends Controller
{
    public function index()
    {
        return view('manager.gcash.index', [
            'accounts' => GCashAccount::latest()->paginate(12),
        ]);
    }

    public function edit(GCashAccount $gcash)
    {
        return view('manager.gcash.edit', ['account' => $gcash]);
    }

    public function update(UpdateGCashRequest $request, GCashAccount $gcash, PhotoStorage $storage)
    {
        $data = $request->validated();
        $data['qr_path'] = $storage->replace($request->file('qr'), $gcash->qr_path, 'gcash');
        $data['is_active'] = $request->boolean('is_active');
        unset($data['qr']);

        $gcash->update($data);

        return redirect()->route('manager.gcash.index')->with('status', 'GCash account updated.');
    }
}
