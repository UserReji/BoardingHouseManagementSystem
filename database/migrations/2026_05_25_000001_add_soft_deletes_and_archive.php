<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rooms', fn (Blueprint $t) => $t->softDeletes());
        Schema::table('billing_periods', fn (Blueprint $t) => $t->softDeletes());
        Schema::table('tenant_bills', fn (Blueprint $t) => $t->softDeletes());
        Schema::table('meter_readings', fn (Blueprint $t) => $t->softDeletes());
        Schema::table('receipts', fn (Blueprint $t) => $t->softDeletes());
        Schema::table('photos', fn (Blueprint $t) => $t->softDeletes());
        Schema::table('announcements', fn (Blueprint $t) => $t->softDeletes());
        Schema::table('gcash_accounts', fn (Blueprint $t) => $t->softDeletes());

        Schema::table('users', function (Blueprint $t) {
            $t->date('move_out_date')->nullable()->after('move_in_date');
            $t->string('deactivation_reason')->nullable()->after('move_out_date');
            $t->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('rooms', fn (Blueprint $t) => $t->dropSoftDeletes());
        Schema::table('billing_periods', fn (Blueprint $t) => $t->dropSoftDeletes());
        Schema::table('tenant_bills', fn (Blueprint $t) => $t->dropSoftDeletes());
        Schema::table('meter_readings', fn (Blueprint $t) => $t->dropSoftDeletes());
        Schema::table('receipts', fn (Blueprint $t) => $t->dropSoftDeletes());
        Schema::table('photos', fn (Blueprint $t) => $t->dropSoftDeletes());
        Schema::table('announcements', fn (Blueprint $t) => $t->dropSoftDeletes());
        Schema::table('gcash_accounts', fn (Blueprint $t) => $t->dropSoftDeletes());
        Schema::table('users', function (Blueprint $t) {
            $t->dropColumn(['move_out_date', 'deactivation_reason']);
            $t->dropSoftDeletes();
        });
    }
};
