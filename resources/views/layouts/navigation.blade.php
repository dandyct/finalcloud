<nav x-data="{ open: false }" class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center gap-4">
                <!-- Logo -->
                <a href="{{ route(Route::has('dashboard') ? 'dashboard' : 'equipments.index') }}" class="flex items-center">
                    <!-- tamaño controlado por el componente -->
                    <x-application-logo class="h-8 w-auto text-gray-800" />
                    <span class="ml-2 font-semibold text-lg text-gray-900 hidden sm:inline">{{ config('app.name', 'MiApp') }}</span>
                </a>

                <!-- Primary Links -->
                <div class="hidden sm:flex sm:space-x-4 ml-6">
                    <x-nav-link :href="route('equipments.index')" :active="request()->routeIs('equipments.*')">
                        {{ __('Equipos') }}
                    </x-nav-link>

                    @auth
                        <x-nav-link :href="route(Route::has('dashboard') ? 'dashboard' : 'equipments.index')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>

                        <x-nav-link :href="route('rentals.index')" :active="request()->routeIs('rentals.*')">
                            {{ __('Rentas') }}
                        </x-nav-link>
                    @endauth
                </div>
            </div>

            <div class="flex items-center gap-4">
                <!-- Auth links / dropdown -->
                @auth
                    <div class="hidden sm:flex sm:items-center sm:gap-3">
                        <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>

                        <x-dropdown align="right" width="48" class="ml-2">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-2 py-1 border rounded text-gray-600 hover:text-gray-800">
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.show')"> {{ __('Profile') }} </x-dropdown-link>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <div class="hidden sm:flex sm:items-center sm:gap-3">
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-gray-900">Iniciar sesión</a>
                        @if(Route::has('register'))
                            <a href="{{ route('register') }}" class="text-sm text-gray-700 hover:text-gray-900">Registrarse</a>
                        @endif
                    </div>
                @endauth

                <!-- Mobile menu button -->
                <div class="sm:hidden -mr-2 flex items-center">
                    <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden border-t border-gray-100">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('equipments.index')" :active="request()->routeIs('equipments.*')">
                {{ __('Equipos') }}
            </x-responsive-nav-link>

            @auth
                <x-responsive-nav-link :href="route(Route::has('dashboard') ? 'dashboard' : 'equipments.index')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('rentals.index')" :active="request()->routeIs('rentals.*')">
                    {{ __('Rentas') }}
                </x-responsive-nav-link>
            @endauth
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ auth()->user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1 px-2">
                    <x-responsive-nav-link :href="route('profile.show')"> {{ __('Profile') }} </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="px-4">
                    <x-responsive-nav-link :href="route('login')"> {{ __('Iniciar sesión') }} </x-responsive-nav-link>
                    @if(Route::has('register'))
                        <x-responsive-nav-link :href="route('register')"> {{ __('Registrarse') }} </x-responsive-nav-link>
                    @endif
                </div>
            @endauth
        </div>
    </div>
</nav>