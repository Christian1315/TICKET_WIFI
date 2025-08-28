<div class="w-64 mb min-h-screen bg-white hidden md:block">
    <nav class="">
        <div x-data="{ open: false }">
            <!--  -->
            <x-sidebar-item class="shadow" :href="route('dashboard')" :active="request()->routeIs('dashboard')">{{ __('Tableau de bord') }}</x-sidebar-item>
            <!-- if(auth()->user()->isAdmin()) -->
            <x-sidebar-item class="shadow" :href="route('router.index')" :active="request()->routeIs('router.index') || 
            request()->routeIs('router.create') || 
            request()->routeIs('router.show') || 
            request()->routeIs('router.edit')">{{ __('Mes wifi zone') }} (Routers) </x-sidebar-item>
            <!-- endif -->

            <x-sidebar-item class="shadow" :href="route('packages.index')" :active="request()->routeIs('packages.index') || 
            request()->routeIs('packages.create') || 
            request()->routeIs('packages.show') || 
            request()->routeIs('packages.edit')">{{ __('Tarifs') }} (Packages)</x-sidebar-item>

            <x-sidebar-item class="shadow" :href="route('ticket.index')" :active="request()->routeIs('ticket.index') ||
            request()->routeIs('ticket.create') ||
            request()->routeIs('ticket.show')">{{ __('Ticket') }}</x-sidebar-item>

            @if(auth()->user()->isAdmin())
            <x-sidebar-item class="shadow" :href="route('users.index')" :active="request()->routeIs('users.index') || 
            request()->routeIs('users.create') ||
            request()->routeIs('users.edit') || 
            request()->routeIs('users.show') ||
            request()->routeIs('payment.create')">{{ __('Users') }}</x-sidebar-item>
            <x-sidebar-item class="shadow" :href="route('company.edit')" :active="request()->routeIs('company.edit')">{{ __('FAI') }}</x-sidebar-item>
            @endif

            <x-sidebar-item class="shadow" :href="route('billing.index')" :active="request()->routeIs('billing.index') ||
            request()->routeIs('billing.create') || 
            request()->routeIs('payment.create')">{{ __('Facturation') }}</x-sidebar-item>
            <x-sidebar-item class="shadow" :href="route('payment.index')" :active="request()->routeIs('payment.index')">{{ __('Payment') }}</x-sidebar-item>

        </div>
    </nav>
</div>