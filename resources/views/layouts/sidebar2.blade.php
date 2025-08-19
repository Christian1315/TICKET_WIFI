<div class="w-64 min-h-screen bg-white hidden md:block">
    <nav class="">
        <div x-data="{ open: false }">
            <!--  -->
            <x-sidebar-item class="shadow" :href="route('dashboard')" :active="request()->routeIs('dashboard')">{{ __('Tableau de bord') }}</x-sidebar-item>
            @if(auth()->user()->isAdmin())
            <x-sidebar-item class="shadow" :href="route('router.index')" :active="request()->routeIs('router.index') || 
            request()->routeIs('router.create') || 
            request()->routeIs('router.show') || 
            request()->routeIs('router.edit')">{{ __('Routers') }}</x-sidebar-item>
            @endif

            <x-sidebar-item class="shadow" :href="route('packages.index')" :active="request()->routeIs('packages.index') || 
            request()->routeIs('packages.create') || 
            request()->routeIs('packages.show') || 
            request()->routeIs('packages.edit')">{{ __('Packages') }}</x-sidebar-item>

            @if(auth()->user()->isAdmin())
            <x-sidebar-item class="shadow" :href="route('users.index')" :active="request()->routeIs('users.index') || request()->routeIs('users.create')">{{ __('Users') }}</x-sidebar-item>
            <x-sidebar-item class="shadow" :href="route('company.edit')" :active="request()->routeIs('company.edit')">{{ __('ISP') }}</x-sidebar-item>
            @endif

            <x-sidebar-item class="shadow" :href="route('billing.index')" :active="request()->routeIs('billing.index')">{{ __('Billing') }}</x-sidebar-item>
            <x-sidebar-item class="shadow" :href="route('payment.index')" :active="request()->routeIs('payment.index')">{{ __('Payment') }}</x-sidebar-item>
            <x-sidebar-item class="shadow" :href="route('ticket.index')" :active="request()->routeIs('ticket.index')">{{ __('Ticket') }}</x-sidebar-item>

            <!-- <input type="text" placeholder="Search.." class="w-100" id="myInput" onkeyup="filterFunction()"> -->
            <x-sidebar-item class="shadow" :href="route('ticket.index')" :active="request()->routeIs('ticket.index')">{{ __('Base') }}</x-sidebar-item>
            <x-sidebar-item class="shadow" :href="route('ticket.index')" :active="request()->routeIs('ticket.index')">{{ __('Blog') }}</x-sidebar-item>
            <x-sidebar-item class="shadow" :href="route('ticket.index')" :active="request()->routeIs('ticket.index')">{{ __('Contact') }}</x-sidebar-item>

            <x-sidebar-item class="shadow w-100" onclick="dropDownFun()">{{ __('Dropdown') }}</x-sidebar-item>
            <x-sidebar-dropdown>

                <!-- <button onclick="dropDownFun()" class="btn">Dropdown</button> -->
                <div id="myDropdown" class="dropdown-content">

                    <input type="text" placeholder="Search.." class="w-100" id="myInput" onkeyup="filterFunction()">

                </div>
            </x-sidebar-dropdown>
        </div>

    </nav>
</div>

@push("scripts")
<script type="text/javascript">
    /* When the user clicks on the button,
    toggle between hiding and showing the dropdown content */
    function dropDownFun() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    function filterFunction() {
        const input = document.getElementById("myInput");
        const filter = input.value.toUpperCase();
        const div = document.getElementById("myDropdown");
        const a = div.getElementsByTagName("a");
        for (let i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                a[i].style.display = "";
            } else {
                a[i].style.display = "none";
            }
        }
    }
</script>
@endpush