<aside class="sidebar">
    <x-shared.app-logo />
    <nav class="nav-list">
        <x-manager.nav-item :href="route('manager.dashboard')" :active="request()->routeIs('manager.dashboard')">Dashboard</x-manager.nav-item>
        <x-manager.nav-item :href="route('manager.tenants.index')" :active="request()->routeIs('manager.tenants.index') || request()->routeIs('manager.tenants.create') || request()->routeIs('manager.tenants.edit') || request()->routeIs('manager.tenants.show')">Tenants</x-manager.nav-item>
        <x-manager.nav-item :href="route('manager.tenants.archived')" :active="request()->routeIs('manager.tenants.archived')" style="padding-left:28px;font-size:13px;opacity:.8">↳ Archived</x-manager.nav-item>
        <x-manager.nav-item :href="route('manager.billing-periods.index')" :active="request()->routeIs('manager.billing-periods.index') || request()->routeIs('manager.billing-periods.create') || request()->routeIs('manager.billing-periods.edit') || request()->routeIs('manager.billing-periods.show')">Billing Periods</x-manager.nav-item>
        <x-manager.nav-item :href="route('manager.billing-periods.archived')" :active="request()->routeIs('manager.billing-periods.archived')" style="padding-left:28px;font-size:13px;opacity:.8">↳ Archived</x-manager.nav-item>
        <x-manager.nav-item :href="route('manager.tenant-bills.index')" :active="request()->routeIs('manager.tenant-bills.*')">Bills</x-manager.nav-item>
        <x-manager.nav-item :href="route('manager.meter-readings.index')" :active="request()->routeIs('manager.meter-readings.*')">Meter Readings</x-manager.nav-item>
        <x-manager.nav-item :href="route('manager.receipts.index')" :active="request()->routeIs('manager.receipts.*')">Receipts</x-manager.nav-item>
        <x-manager.nav-item :href="route('manager.photos.index')" :active="request()->routeIs('manager.photos.*')">Photos</x-manager.nav-item>
        <x-manager.nav-item :href="route('manager.announcements.index')" :active="request()->routeIs('manager.announcements.*')">Announcements</x-manager.nav-item>
        <x-manager.nav-item :href="route('manager.gcash.index')" :active="request()->routeIs('manager.gcash.*')">GCash</x-manager.nav-item>
        <x-manager.nav-item :href="route('manager.reports.index')" :active="request()->routeIs('manager.reports.*')">Reports</x-manager.nav-item>
    </nav>
</aside>
