<aside class="sidebar">
    <x-shared.app-logo />
    <nav class="nav-list">
        <x-tenant.nav-item :href="route('tenant.dashboard')" :active="request()->routeIs('tenant.dashboard')">Dashboard</x-tenant.nav-item>
        <x-tenant.nav-item :href="route('tenant.bills.index')" :active="request()->routeIs('tenant.bills.*')">Bills</x-tenant.nav-item>
        <x-tenant.nav-item :href="route('tenant.payments.index')" :active="request()->routeIs('tenant.payments.*')">Payments</x-tenant.nav-item>
        <x-tenant.nav-item :href="route('tenant.receipts.index')" :active="request()->routeIs('tenant.receipts.*')">Receipts</x-tenant.nav-item>
        <x-tenant.nav-item :href="route('tenant.meter-readings.index')" :active="request()->routeIs('tenant.meter-readings.*')">Meter Readings</x-tenant.nav-item>
        <x-tenant.nav-item :href="route('tenant.gcash.show')" :active="request()->routeIs('tenant.gcash.*')">GCash</x-tenant.nav-item>
        <x-tenant.nav-item :href="route('tenant.gallery.index')" :active="request()->routeIs('tenant.gallery.*')">Gallery</x-tenant.nav-item>
        <x-tenant.nav-item :href="route('tenant.announcements.index')" :active="request()->routeIs('tenant.announcements.*')">Announcements</x-tenant.nav-item>
        <x-tenant.nav-item :href="route('tenant.profile.edit')" :active="request()->routeIs('tenant.profile.*')">Profile</x-tenant.nav-item>
    </nav>
</aside>
