<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold text-blue-600">
                        BusTicket
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    
                    @if (auth()->user()->isUser())
                        <x-nav-link :href="route('pemesanan.index')" :active="request()->routeIs('pemesanan.*')">
                            Pesan Tiket
                        </x-nav-link>
                        <x-nav-link :href="route('pemesanan.my-orders')" :active="request()->routeIs('pemesanan.my-orders')">
                            Pesanan Saya
                        </x-nav-link>
                    @endif

                    @if (auth()->user()->isAdmin())
                        <x-nav-link :href="route('admin.armada.index')" :active="request()->routeIs('admin.armada.*')">
                            Kelola Armada
                        </x-nav-link>
                        <x-nav-link :href="route('admin.pembayaran.index')" :active="request()->routeIs('admin.pembayaran.*')">
                            Verifikasi Pembayaran
                        </x-nav-link>
                        <x-nav-link :href="route('admin.reschedule.index')" :active="request()->routeIs('admin.reschedule.*')">
                            Reschedule
                        </x-nav-link>
                        <x-nav-link :href="route('admin.pembatalan.index')" :active="request()->routeIs('admin.pembatalan.*')">
                            Pembatalan
                        </x-nav-link>
                    @endif

                    @if (auth()->user()->isOwner())
                        <x-nav-link :href="route('laporan.index')" :active="request()->routeIs('laporan.*')">
                            Laporan
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>