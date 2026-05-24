<?php

namespace Database\Seeders;

use App\Enums\BillStatus;
use App\Enums\MeterType;
use App\Enums\ReceiptStatus;
use App\Enums\UserRole;
use App\Models\Announcement;
use App\Models\BillingPeriod;
use App\Models\GCashAccount;
use App\Models\MeterReading;
use App\Models\Photo;
use App\Models\Receipt;
use App\Models\Room;
use App\Models\TenantBill;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $manager = User::query()->updateOrCreate(
            ['email' => 'manager@example.com'],
            [
                'name' => 'House Manager',
                'password' => Hash::make('password'),
                'role' => UserRole::Manager,
                'phone' => '0917 000 0001',
                'is_active' => true,
            ],
        );

        $roomA = Room::query()->updateOrCreate(
            ['code' => 'A-101'],
            [
                'name' => 'Room A-101',
                'floor' => '1st Floor',
                'monthly_rent' => 4500,
                'occupancy_limit' => 2,
                'notes' => 'Near the main entrance.',
                'is_active' => true,
            ],
        );

        $roomB = Room::query()->updateOrCreate(
            ['code' => 'B-204'],
            [
                'name' => 'Room B-204',
                'floor' => '2nd Floor',
                'monthly_rent' => 5200,
                'occupancy_limit' => 1,
                'notes' => 'Single room with window.',
                'is_active' => true,
            ],
        );

        $tenant = User::query()->updateOrCreate(
            ['email' => 'tenant@example.com'],
            [
                'name' => 'Sample Tenant',
                'password' => Hash::make('password'),
                'role' => UserRole::Tenant,
                'phone' => '0917 000 0002',
                'address' => 'Sample City',
                'emergency_contact' => 'Parent - 0917 000 0003',
                'room_id' => $roomA->id,
                'move_in_date' => now()->subMonths(2)->toDateString(),
                'is_active' => true,
            ],
        );

        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('042791'),
                'role' => UserRole::Manager,
                'phone' => '0917 000 0003',
                'address' => 'Admin City',
                'emergency_contact' => 'Contact - 0917 000 0004',
                'room_id' => $roomB->id,
                'move_in_date' => now()->subMonths(1)->toDateString(),
                'is_active' => true,
            ],
        );

        $period = BillingPeriod::query()->updateOrCreate(
            ['name' => now()->format('F Y')],
            [
                'starts_at' => now()->startOfMonth()->toDateString(),
                'ends_at' => now()->endOfMonth()->toDateString(),
                'due_at' => now()->startOfMonth()->addDays(10)->toDateString(),
                'is_closed' => false,
            ],
        );

        $bill = TenantBill::query()->updateOrCreate(
            ['user_id' => $tenant->id, 'billing_period_id' => $period->id],
            [
                'room_id' => $roomA->id,
                'rent_amount' => 4500,
                'electricity_amount' => 680,
                'water_amount' => 220,
                'other_charges' => 150,
                'discount_amount' => 0,
                'amount_paid' => 2500,
                'status' => BillStatus::Partial,
                'due_at' => $period->due_at,
                'notes' => 'Seeded bill for demo use.',
            ],
        );

        MeterReading::query()->updateOrCreate(
            ['user_id' => $tenant->id, 'billing_period_id' => $period->id, 'type' => MeterType::Electricity],
            [
                'room_id' => $roomA->id,
                'previous_reading' => 1200,
                'current_reading' => 1285,
                'rate' => 8,
                'amount' => 680,
                'read_at' => now()->toDateString(),
            ],
        );

        MeterReading::query()->updateOrCreate(
            ['user_id' => $tenant->id, 'billing_period_id' => $period->id, 'type' => MeterType::Water],
            [
                'room_id' => $roomA->id,
                'previous_reading' => 315,
                'current_reading' => 326,
                'rate' => 20,
                'amount' => 220,
                'read_at' => now()->toDateString(),
            ],
        );

        Receipt::query()->updateOrCreate(
            ['reference_number' => 'GCASH-DEMO-001'],
            [
                'user_id' => $tenant->id,
                'tenant_bill_id' => $bill->id,
                'amount' => 2500,
                'paid_at' => now()->subDays(2)->toDateString(),
                'status' => ReceiptStatus::Approved,
                'reviewed_by' => $manager->id,
                'reviewed_at' => now()->subDay(),
                'reviewer_notes' => 'Seeded approved receipt.',
            ],
        );

        GCashAccount::query()->updateOrCreate(
            ['account_number' => '09170000000'],
            [
                'account_name' => 'Boarding House Payments',
                'instructions' => 'Send payment through GCash, then upload the receipt with the reference number.',
                'is_active' => true,
            ],
        );

        Photo::query()->updateOrCreate(
            ['title' => 'Front Hall'],
            [
                'room_id' => $roomB->id,
                'uploaded_by' => $manager->id,
                'description' => 'Common hallway and access area.',
                'path' => 'photos/sample-front-hall.jpg',
                'taken_at' => now()->toDateString(),
                'is_featured' => true,
                'visibility' => 'tenants',
            ],
        );

        Announcement::query()->updateOrCreate(
            ['title' => 'Monthly rent reminder'],
            [
                'body' => 'Please settle balances before the due date and upload your receipt after payment.',
                'audience' => 'all',
                'published_at' => now(),
                'expires_at' => now()->addMonth(),
                'is_pinned' => true,
                'created_by' => $manager->id,
            ],
        );
    }
}
