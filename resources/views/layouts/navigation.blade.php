<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="flex items-center space-x-2">
                    <!-- Visible Checkbox for showing/hiding the navigation -->
                    <input type="checkbox" id="nav-toggle" class="hidden" />
                    <label for="nav-toggle" class="cursor-pointer p-2 bg-gray-300 rounded-md">Toggle Navigation</label>

                    <!-- Navigation links wrapped inside a container that is shown/hidden based on checkbox -->
                    <div id="nav-container" class="hidden space-x-2 sm:-my-px sm:ms-4 sm:flex">
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>

                        <x-nav-link :href="route('pizzas.index')" :active="request()->routeIs('pizzas.index')">
                            {{ __('Pizzas') }}
                        </x-nav-link>

                        <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                            {{ __('Users') }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('ingredients.index')" :active="request()->routeIs('ingredients.index')">
                            {{ __('Ingredients') }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('pizza_ingredients.index')" :active="request()->routeIs('pizza_ingredients.index')">
                            {{ __('Pizza Ingredients') }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('extra_ingredients.index')" :active="request()->routeIs('extra_ingredients.index')">
                            {{ __('Extra Ingredients') }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')">
                            {{ __('Orders') }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('orders_pizza.index')" :active="request()->routeIs('orders_pizza.index')">
                            {{ __('Orders Pizza') }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('order_extra_ingredients.index')" :active="request()->routeIs('order_extra_ingredients.index')">
                            {{ __('Order Extra Ingredients') }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('branches.index')" :active="request()->routeIs('branches.index')">
                            {{ __('Branches') }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('suppliers.index')" :active="request()->routeIs('suppliers.index')">
                            {{ __('Suppliers') }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('raw_materials.index')" :active="request()->routeIs('raw_materials.index')">
                            {{ __('Raw Materials') }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('purchases.index')" :active="request()->routeIs('purchases.index')">
                            {{ __('Purchases') }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('pizza_raw_materials.index')" :active="request()->routeIs('pizza_raw_materials.index')">
                            {{ __('Pizza Raw Materials') }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('pizzas_sizes.index')" :active="request()->routeIs('pizzas_sizes.index')">
                            {{ __('Pizzas Sizes') }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('clients.index')" :active="request()->routeIs('clients.index')">
                            {{ __('Clients') }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('employees.index')" :active="request()->routeIs('employees.index')">
                            {{ __('Employees') }}
                        </x-responsive-nav-link>
                    </div>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
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
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div class="hidden sm:hidden">
        <!-- Container that holds the links and is toggled via the checkbox -->
        <div id="nav-toggle-container" class="space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('pizzas.index')" :active="request()->routeIs('pizzas.index')">
                {{ __('Pizzas') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                            {{ __('Users') }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('ingredients.index')" :active="request()->routeIs('ingredients.index')">
                            {{ __('Ingredients') }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('pizza_ingredients.index')" :active="request()->routeIs('pizza_ingredients.index')">
                            {{ __('Pizza Ingredients') }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('extra_ingredients.index')" :active="request()->routeIs('extra_ingredients.index')">
                            {{ __('Extra Ingredients') }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')">
                            {{ __('Orders') }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('orders_pizza.index')" :active="request()->routeIs('orders_pizza.index')">
                            {{ __('Orders Pizza') }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('order_extra_ingredients.index')" :active="request()->routeIs('order_extra_ingredients.index')">
                            {{ __('Order Extra Ingredients') }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('branches.index')" :active="request()->routeIs('branches.index')">
                            {{ __('Branches') }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('suppliers.index')" :active="request()->routeIs('suppliers.index')">
                            {{ __('Suppliers') }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('raw_materials.index')" :active="request()->routeIs('raw_materials.index')">
                            {{ __('Raw Materials') }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('purchases.index')" :active="request()->routeIs('purchases.index')">
                            {{ __('Purchases') }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('pizza_raw_materials.index')" :active="request()->routeIs('pizza_raw_materials.index')">
                            {{ __('Pizza Raw Materials') }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('pizzas_sizes.index')" :active="request()->routeIs('pizzas_sizes.index')">
                            {{ __('Pizzas Sizes') }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('clients.index')" :active="request()->routeIs('clients.index')">
                            {{ __('Clients') }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('employees.index')" :active="request()->routeIs('employees.index')">
                            {{ __('Employees') }}
                        </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
