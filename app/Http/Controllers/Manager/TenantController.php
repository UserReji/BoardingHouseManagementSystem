<?php

namespace App\Http\Controllers\Manager;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class TenantController extends Controller
{
    public function index()
    {
        return view('manager.tenants.index', [
            'tenants' => User::with('room')
                ->where('role', UserRole::Tenant)
                ->where('is_active', true)
                ->latest()
                ->paginate(12),
        ]);
    }

    public function archived()
    {
        return view('manager.tenants.archived', [
            'tenants' => User::withTrashed()
                ->where('role', UserRole::Tenant)
                ->where(function ($q) {
                    $q->where('is_active', false)->orWhereNotNull('deleted_at');
                })
                ->with('room')
                ->latest()
                ->paginate(12),
        ]);
    }

    public function create()
    {
        return view('manager.tenants.create', [
            'rooms' => Room::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedTenant($request);
        $data['role'] = UserRole::Tenant;
        $data['password'] = Hash::make($data['password']);
        $data['is_active'] = $request->boolean('is_active', true);

        User::create($data);

        return redirect()->route('manager.tenants.index')->with('status', 'Tenant added successfully.');
    }

    public function show(User $tenant)
    {
        $this->ensureTenant($tenant);

        return view('manager.tenants.show', [
            'tenant' => $tenant->load('room', 'tenantBills.billingPeriod', 'receipts'),
        ]);
    }

    public function edit(User $tenant)
    {
        $this->ensureTenant($tenant);

        return view('manager.tenants.edit', [
            'tenant' => $tenant,
            'rooms' => Room::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, User $tenant)
    {
        $this->ensureTenant($tenant);
        $data = $this->validatedTenant($request, $tenant);
        $data['is_active'] = $request->boolean('is_active');
        $data['move_out_date'] = $request->input('move_out_date');
        $data['deactivation_reason'] = $request->input('deactivation_reason');

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $tenant->update($data);

        return redirect()->route('manager.tenants.show', $tenant)->with('status', 'Tenant updated.');
    }

    /**
     * Deactivate (archive) a tenant — keeps all their records.
     */
    public function destroy(Request $request, User $tenant)
    {
        $this->ensureTenant($tenant);

        $tenant->update([
            'is_active' => false,
            'move_out_date' => $request->input('move_out_date', now()->toDateString()),
            'deactivation_reason' => $request->input('deactivation_reason', 'Moved out'),
        ]);

        return redirect()->route('manager.tenants.index')->with('status', 'Tenant has been archived. Their records are preserved.');
    }

    /**
     * Permanently delete — only from archived list.
     */
    public function forceDelete(User $tenant)
    {
        $this->ensureTenant($tenant);
        $tenant->forceDelete();

        return redirect()->route('manager.tenants.archived')->with('status', 'Tenant permanently deleted.');
    }

    /**
     * Restore a deactivated tenant back to active.
     */
    public function restore(User $tenant)
    {
        $this->ensureTenant($tenant);

        $tenant->update([
            'is_active' => true,
            'move_out_date' => null,
            'deactivation_reason' => null,
        ]);

        if ($tenant->trashed()) {
            $tenant->restore();
        }

        return redirect()->route('manager.tenants.archived')->with('status', 'Tenant restored to active.');
    }

    private function validatedTenant(Request $request, ?User $tenant = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($tenant)],
            'password' => [$tenant ? 'nullable' : 'required', 'string', 'min:8'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string'],
            'emergency_contact' => ['nullable', 'string', 'max:255'],
            'room_id' => ['nullable', 'exists:rooms,id'],
            'move_in_date' => ['nullable', 'date'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }

    private function ensureTenant(User $tenant): void
    {
        abort_unless($tenant->isTenant(), 404);
    }
}
