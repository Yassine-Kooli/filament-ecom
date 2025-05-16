<div>
    <section class="py-10 bg-gray-50 font-poppins dark:bg-gray-800 rounded-lg">
        <div class="px-4 py-4 mx-auto max-w-7xl lg:py-6 md:px-6">
            <div class="flex flex-wrap mb-24">
                <div class="w-full lg:w-1/4 pr-0 lg:pr-4">
                    <div class="p-4 mb-5 bg-white border border-gray-200 dark:border-gray-900 dark:bg-gray-900">
                        <h2 class="text-2xl font-bold dark:text-gray-400">Categories</h2>
                        <div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div>
                        <div class="max-h-60 overflow-y-auto pr-2">
                            <ul>
                                @foreach ($categories as $category)
                                    <li class="mb-3" wire:key="{{ $category->id }}">
                                        <label for="{{ $category->slug }}" class="flex items-center dark:text-gray-400">
                                            <input type="checkbox" wire:model.live='selected_categories'
                                                id="{{ $category->slug }}" value="{{ $category->id }}" class="w-4 h-4 mr-2">
                                            <span class="text-lg">{{ $category->name }}</span>
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="p-4 mb-5 bg-white border border-gray-200 dark:bg-gray-900 dark:border-gray-900">
                        <h2 class="text-2xl font-bold dark:text-gray-400">Brand</h2>
                        <div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div>
                        <div class="max-h-60 overflow-y-auto pr-2">
                            <ul>
                                @foreach ($brands as $brand)
                                    <li class="mb-3" wire:key="{{ $brand->id }}">
                                        <label for="{{ $brand->slug }}" class="flex items-center dark:text-gray-300">
                                            <input type="checkbox" wire:model.live='selected_brands' class="w-4 h-4 mr-2"
                                                id="{{ $brand->slug }}" value="{{ $brand->id }}">
                                            <span class="text-lg dark:text-gray-400">{{ $brand->name }}</span>
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="p-4 mb-5 bg-white border border-gray-200 dark:bg-gray-900 dark:border-gray-900">
                        <h2 class="text-2xl font-bold dark:text-gray-400">Product Status</h2>
                        <div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div>
                        <ul>
                            <li class="mb-3">
                                <label for="featured" class="flex items-center dark:text-gray-300">
                                    <input type="checkbox" wire:model.live='featured' id="featured" value="1"
                                        class="w-4 h-4 mr-2">
                                    <span class="text-lg dark:text-gray-400">Featured Product</span>
                                </label>
                            </li>
                            <li class="mb-3">
                                <label for="on_sale" class="flex items-center dark:text-gray-300">
                                    <input type="checkbox" wire:model.live='on_sale' id="on_sale" value="1"
                                        class="w-4 h-4 mr-2">
                                    <span class="text-lg dark:text-gray-400">On Sale</span>
                                </label>
                            </li>
                        </ul>
                    </div>

                    <div class="p-4 mb-5 bg-white border border-gray-200 dark:bg-gray-900 dark:border-gray-900">
                        <h2 class="text-2xl font-bold dark:text-gray-400">Price</h2>
                        <div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div>
                        <div>
                            <div class="font-semibold text-lg mb-2">{{ Number::currency($price_range) }}</div>
                            <input type="range" wire:model.live="price_range"
                                class="w-full h-1 mb-4 bg-blue-100 rounded appearance-none cursor-pointer" max="10000"
                                value="5000" step="10">
                            <div class="flex justify-between">
                                <span
                                    class="inline-block text-lg font-bold text-blue-400">{{ Number::currency(10)}}</span>
                                <span
                                    class="inline-block text-lg font-bold text-blue-400">{{ Number::currency(10000)}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full lg:w-3/4 pl-0 lg:pl-4">
                    <div class="px-3 mb-4">
                        <div
                            class="items-center justify-between hidden px-3 py-2 bg-gray-100 md:flex dark:bg-gray-900 ">
                            <div class="flex items-center justify-between">
                                <select wire:model.live="sort" id=""
                                    class="block w-40 text-base bg-gray-100 cursor-pointer dark:text-gray-400 dark:bg-gray-900">
                                    <option value="latest">Sort by latest</option>
                                    <option value="price">Sort by Price</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

                        @foreach ($products as $product)
                            <div wire:key="{{ $product->id }}" data-animation="slide-up">
                                <div
                                    class="card group relative overflow-hidden bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 h-full flex flex-col">
                                    <!-- Product badge (featured or sale) -->
                                    @if($product->is_featured)
                                        <div class="absolute top-4 left-4 z-10">
                                            <span
                                                class="bg-primary-500 text-white text-xs font-bold px-3 py-1.5 rounded-full">Featured</span>
                                        </div>
                                    @elseif($product->on_sale)
                                        <div class="absolute top-4 left-4 z-10">
                                            <span
                                                class="bg-accent-500 text-white text-xs font-bold px-3 py-1.5 rounded-full">Sale</span>
                                        </div>
                                    @endif

                                    <!-- Quick action buttons -->
                                    <div
                                        class="absolute right-4 top-4 z-10 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <button wire:click.prevent='addToCart({{ $product->id }})' data-add-to-cart
                                            class="bg-white dark:bg-gray-700 p-2 rounded-full shadow-md hover:bg-primary-50 dark:hover:bg-gray-600 transition-colors duration-300">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5 text-primary-600 dark:text-primary-400" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Product image with hover effect -->
                                    <div class="relative overflow-hidden">
                                        <a href="/products/{{ $product->slug }}" class="block">
                                            <div class="aspect-w-1 aspect-h-1 bg-gray-200 dark:bg-gray-700">
                                                <img src="{{ url('storage', $product->images[0]) }}"
                                                    alt="{{ $product->name }}"
                                                    class="product-image-zoom object-cover w-full h-64 transform transition-transform duration-500 group-hover:scale-110">
                                            </div>
                                        </a>
                                    </div>

                                    <!-- Product info -->
                                    <div class="p-5 flex flex-col flex-grow">
                                        <div class="mb-2">
                                            <h3
                                                class="text-lg font-medium text-gray-900 dark:text-gray-100 line-clamp-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-300">
                                                {{ $product->name }}
                                            </h3>
                                        </div>

                                        <div class="mt-auto">
                                            <div class="flex items-center justify-between">
                                                <p class="text-xl font-bold text-primary-600 dark:text-primary-400">
                                                    {{ Number::currency($product->price) }}
                                                </p>

                                                <button wire:click.prevent='addToCart({{ $product->id }})'
                                                    class="inline-flex items-center justify-center bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-300">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                    </svg>
                                                    Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                    </div>
                    <!-- pagination start -->
                    <div class="mt-10">
                        <div class="flex justify-center">
                            <nav aria-label="page-navigation" class="pagination-container">
                                {{ $products->links() }}
                            </nav>
                        </div>
                    </div>
                    <!-- pagination end -->
                </div>
            </div>
        </div>
    </section>

</div>