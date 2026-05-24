<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\MeterReading;
use Illuminate\Http\Request;

class MeterReadingController extends Controller
{
    public function index(Request $request)
    {
        return view('tenant.meter-readings.index', [
            'readings' => MeterReading::with('billingPeriod')->where('user_id', $request->user()->id)->latest()->paginate(12),
        ]);
    }

    public function show(Request $request, MeterReading $meterReading)
    {
        abort_unless($meterReading->user_id === $request->user()->id, 403);

        return view('tenant.meter-readings.show', ['reading' => $meterReading->load('billingPeriod', 'room')]);
    }
}
