<!-- Navigation Links -->
<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        {{ __('Dashboard') }}
    </x-nav-link>
    <x-nav-link :href="route('tickets.index')" :active="request()->routeIs('tickets.*')">
        {{ __('Chamados') }}
    </x-nav-link>
</div> 