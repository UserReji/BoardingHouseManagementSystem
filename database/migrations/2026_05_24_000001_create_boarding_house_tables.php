<?php

use App\Enums\BillStatus;
use App\Enums\MeterType;
use App\Enums\ReceiptStatus;
use App\Enums\UserRole;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('floor')->nullable();
            $table->decimal('monthly_rent', 10, 2)->default(0);
            $table->unsignedSmallInteger('occupancy_limit')->default(1);
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default(UserRole::Tenant->value)->after('password');
            $table->string('phone')->nullable()->after('role');
            $table->text('address')->nullable()->after('phone');
            $table->string('emergency_contact')->nullable()->after('address');
            $table->foreignId('room_id')->nullable()->after('emergency_contact')->constrained()->nullOnDelete();
            $table->date('move_in_date')->nullable()->after('room_id');
            $table->boolean('is_active')->default(true)->after('move_in_date');
        });

        Schema::create('billing_periods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('starts_at');
            $table->date('ends_at');
            $table->date('due_at');
            $table->boolean('is_closed')->default(false);
            $table->timestamps();
        });

        Schema::create('tenant_bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('billing_period_id')->constrained()->cascadeOnDelete();
            $table->decimal('rent_amount', 10, 2)->default(0);
            $table->decimal('electricity_amount', 10, 2)->default(0);
            $table->decimal('water_amount', 10, 2)->default(0);
            $table->decimal('other_charges', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('amount_paid', 10, 2)->default(0);
            $table->string('status')->default(BillStatus::Unpaid->value);
            $table->date('due_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('meter_readings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('billing_period_id')->constrained()->cascadeOnDelete();
            $table->string('type')->default(MeterType::Electricity->value);
            $table->decimal('previous_reading', 10, 2)->default(0);
            $table->decimal('current_reading', 10, 2)->default(0);
            $table->decimal('rate', 10, 2)->default(0);
            $table->decimal('amount', 10, 2)->default(0);
            $table->string('photo_path')->nullable();
            $table->date('read_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tenant_bill_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('amount', 10, 2);
            $table->string('reference_number')->nullable();
            $table->date('paid_at');
            $table->string('image_path')->nullable();
            $table->string('status')->default(ReceiptStatus::Pending->value);
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->text('reviewer_notes')->nullable();
            $table->timestamps();
        });

        Schema::create('gcash_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('account_name');
            $table->string('account_number');
            $table->string('qr_path')->nullable();
            $table->text('instructions')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('path');
            $table->date('taken_at')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->string('visibility')->default('tenants');
            $table->timestamps();
        });

        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body');
            $table->string('audience')->default('all');
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->boolean('is_pinned')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('photos');
        Schema::dropIfExists('gcash_accounts');
        Schema::dropIfExists('receipts');
        Schema::dropIfExists('meter_readings');
        Schema::dropIfExists('tenant_bills');
        Schema::dropIfExists('billing_periods');

        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('room_id');
            $table->dropColumn([
                'role',
                'phone',
                'address',
                'emergency_contact',
                'move_in_date',
                'is_active',
            ]);
        });

        Schema::dropIfExists('rooms');
    }
};
