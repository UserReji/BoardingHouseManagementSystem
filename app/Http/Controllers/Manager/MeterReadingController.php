<?php

namespace App\Http\Controllers\Manager;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\StoreMeterReadingRequest;
use App\Http\Requests\Manager\UpdateMeterReadingRequest;
use App\Models\BillingPeriod;
use App\Models\MeterReading;
use App\Models\Room;
use App\Models\User;
use App\Services\Files\PhotoStorage;

class MeterReadingController extends Controller
{
    public function index()
    {
        return view('manager.meter-readings.index', [
            'readings' => MeterReading::with('tenant', 'room', 'billingPeriod')->latest()->paginate(12),
        ]);
    }

    public function create()
    {
        return view('manager.meter-readings.create', $this->formData());
    }

    public function store(StoreMeterReadingRequest $request, PhotoStorage $storage)
    {
        $data = $request->validated();
        $data['amount'] = ((float) $data['current_reading'] - (float) $data['previous_reading']) * (float) $data['rate'];
        $data['photo_path'] = $storage->store($request->file('photo'), 'meter-readings');

        $reading = MeterReading::create($data);

        return redirect()->route('manager.meter-readings.show', $reading)->with('status', 'Meter reading saved.');
    }

    public function show(MeterReading $meterReading)
    {
        return view('manager.meter-readings.show', ['reading' => $meterReading->load('tenant', 'room', 'billingPeriod')]);
    }

    public function edit(MeterReading $meterReading)
    {
        return view('manager.meter-readings.edit', $this->formData() + ['reading' => $meterReading]);
    }

    public function update(UpdateMeterReadingRequest $request, MeterReading $meterReading, PhotoStorage $storage)
    {
        $data = $request->validated();
        $data['amount'] = ((float) $data['current_reading'] - (float) $data['previous_reading']) * (float) $data['rate'];
        $data['photo_path'] = $storage->replace($request->file('photo'), $meterReading->photo_path, 'meter-readings');
        $meterReading->update($data);

        return redirect()->route('manager.meter-readings.show', $meterReading)->with('status', 'Meter reading updated.');
    }

    public function destroy(MeterReading $meterReading, PhotoStorage $storage)
    {
        $storage->delete($meterReading->photo_path);
        $meterReading->delete();

        return redirect()->route('manager.meter-readings.index')->with('status', 'Meter reading deleted.');
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
