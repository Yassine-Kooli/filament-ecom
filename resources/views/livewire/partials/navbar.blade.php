<header
  class="fixed top-0 left-0 right-0 z-50 w-full bg-white/90 dark:bg-gray-900/90 backdrop-blur-md shadow-sm border-b border-gray-200 dark:border-gray-800 transition-all duration-300">
  <div class="w-full max-w-[85rem] mx-auto">
    <nav class="w-full mx-auto px-4 sm:px-6 lg:px-8 py-3" aria-label="Global">
      <div class="relative flex items-center justify-between">
        <!-- Logo and brand -->
        <div class="flex items-center">
          <a href="/" onclick="window.location.href='/'; return false;"
            class="flex items-center gap-2 text-primary-600 dark:text-primary-400 transition-all duration-300 hover:scale-105"
            aria-label="Brand">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            <span class="text-xl font-bold tracking-tight">ShopWave</span>
          </a>
        </div>

        <!-- Mobile menu button -->
        <div class="md:hidden">
          <button type="button"
            class="hs-collapse-toggle flex justify-center items-center w-10 h-10 rounded-full text-gray-800 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-800 transition-all duration-300"
            data-hs-collapse="#navbar-collapse-with-animation" aria-controls="navbar-collapse-with-animation"
            aria-label="Toggle navigation">
            <svg class="hs-collapse-open:hidden w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg class="hs-collapse-open:block hidden w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <!-- Desktop navigation -->
        <div id="navbar-collapse-with-animation"
          class="hs-collapse hidden overflow-hidden transition-all duration-300 basis-full grow md:block">
          <div class="flex flex-col md:flex-row md:items-center md:justify-end md:gap-x-7 mt-5 md:mt-0">
            <!-- Navigation links -->
            <a href="/" onclick="window.location.href='/'; return false;"
              class="nav-item group flex items-center font-medium py-2 md:py-4 px-2 {{ request()->is('/') ? 'text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-300' }} hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-300"
              aria-current="page">
              <span class="relative">
                Home
                <span
                  class="absolute bottom-0 left-0 w-full h-0.5 bg-primary-600 dark:bg-primary-400 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 {{ request()->is('/') ? 'scale-x-100' : '' }}"></span>
              </span>
            </a>

            <a href="/categories" onclick="window.location.href='/categories'; return false;"
              class="nav-item group flex items-center font-medium py-2 md:py-4 px-2 {{ request()->is('categories') ? 'text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-300' }} hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-300">
              <span class="relative">
                Categories
                <span
                  class="absolute bottom-0 left-0 w-full h-0.5 bg-primary-600 dark:bg-primary-400 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 {{ request()->is('categories') ? 'scale-x-100' : '' }}"></span>
              </span>
            </a>

            <a href="/products" onclick="window.location.href='/products'; return false;"
              class="nav-item group flex items-center font-medium py-2 md:py-4 px-2 {{ request()->is('products') ? 'text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-300' }} hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-300">
              <span class="relative">
                Products
                <span
                  class="absolute bottom-0 left-0 w-full h-0.5 bg-primary-600 dark:bg-primary-400 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 {{ request()->is('products') ? 'scale-x-100' : '' }}"></span>
              </span>
            </a>

            <!-- Cart button with animation -->
            <a href="/cart" onclick="window.location.href='/cart'; return false;"
              class="nav-item relative group flex items-center font-medium py-2 md:py-4 px-2 {{ request()->is('cart') ? 'text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-300' }} hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-300">
              <div class="relative flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg"
                  class="h-6 w-6 mr-1 transition-transform duration-300 group-hover:scale-110" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <span class="mr-1">Cart</span>
                @if($total_count > 0)
          <span
            class="flex items-center justify-center w-6 h-6 rounded-full bg-primary-100 text-primary-700 text-xs font-semibold dark:bg-primary-900 dark:text-primary-300 transition-all duration-300 animate-pulse">{{ $total_count }}</span>
        @else
          <span
            class="flex items-center justify-center w-6 h-6 rounded-full bg-gray-100 text-gray-500 text-xs font-semibold dark:bg-gray-800 dark:text-gray-400">0</span>
        @endif
              </div>
            </a>

            <!-- Authentication -->
            @guest
        <div class="pt-3 md:pt-0 md:pl-2">
          <a href="/login" onclick="window.location.href='/login'; return false;"
          class="btn-primary py-2 px-4 rounded-lg inline-flex items-center gap-x-2 text-sm font-semibold transition-transform duration-300 hover:scale-105 focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
          <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
          </svg>
          Log in
          </a>
        </div>
      @endguest

            <!-- User dropdown -->
            @auth
        <div class="hs-dropdown relative inline-flex md:py-4 [--placement:bottom-right]">
          <button type="button"
          class="flex items-center gap-2 font-medium text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400 transition-colors duration-300">
          <span class="hidden sm:inline-block">{{ auth()->user()->name }}</span>
          <img class="w-8 h-8 rounded-full object-cover border-2 border-gray-200 dark:border-gray-700"
            src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random"
            alt="{{ auth()->user()->name }}">
          <svg class="ms-1 w-4 h-4 transition-transform duration-300 hs-dropdown-open:rotate-180"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
          </button>

          <div
          class="hs-dropdown-menu transition-[opacity,margin] duration-300 hs-dropdown-open:opacity-100 opacity-0 hidden min-w-60 bg-white shadow-md rounded-lg p-2 dark:bg-gray-800 dark:border dark:border-gray-700 dark:divide-gray-700 after:h-4 after:absolute after:-bottom-4 after:start-0 after:w-full before:h-4 before:absolute before:-top-4 before:start-0 before:w-full">
          <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
            href="#" onclick="window.location.href='/my-orders'; return false;">
            <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            My Orders
          </a>
          <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
            href="#" onclick="window.location.href='/my-account'; return false;">
            <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            My Account
          </a>
          <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>
          <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-md text-sm text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20"
            href="#" onclick="window.location.href='/logout'; return false;">
            <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            Logout
          </a>
          </div>
        </div>
      @endauth
          </div>
        </div>
      </div>
    </nav>
  </div>
</header>