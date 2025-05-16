<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

class PerformanceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test data for performance tests
        $this->createTestData();
    }

    protected function createTestData(): void
    {
        // Create categories
        $categories = [];
        for ($i = 1; $i <= 5; $i++) {
            $name = "Test Category $i";
            $categories[] = Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'is_active' => true,
            ]);
        }

        // Create brands
        $brands = [];
        for ($i = 1; $i <= 5; $i++) {
            $name = "Test Brand $i";
            $brands[] = Brand::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'is_active' => true,
            ]);
        }

        // Create products
        for ($i = 1; $i <= 50; $i++) {
            $name = "Test Product $i";
            $product = Product::create([
                'category_id' => $categories[array_rand($categories)]->id,
                'brand_id' => $brands[array_rand($brands)]->id,
                'name' => $name,
                'slug' => Str::slug($name),
                'images' => ['test.jpg'],
                'description' => "This is a test product description for $name",
                'price' => rand(10, 1000) / 10,
                'is_active' => true,
                'is_featured' => rand(0, 1),
                'in_stock' => true,
                'on_sale' => rand(0, 1),
            ]);
        }

        // Create users
        $users = [];
        for ($i = 1; $i <= 10; $i++) {
            $users[] = User::factory()->create();
        }

        // Create orders
        for ($i = 1; $i <= 20; $i++) {
            $user = $users[array_rand($users)];
            $order = Order::create([
                'user_id' => $user->id,
                'grand_total' => 0,
                'payment_method' => 'stripe',
                'payment_status' => 'paid',
                'status' => 'delivered',
                'currency' => 'USD',
                'shipping_cost' => 10,
                'shipping_method' => 'standard',
            ]);

            // Add order items
            $total = 0;
            $productCount = rand(1, 5);
            $randomProducts = Product::inRandomOrder()->limit($productCount)->get();

            foreach ($randomProducts as $product) {
                $quantity = rand(1, 3);
                $unitAmount = $product->price;
                $totalAmount = $unitAmount * $quantity;
                $total += $totalAmount;

                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_amount' => $unitAmount,
                    'total_amount' => $totalAmount,
                ]);
            }

            // Update order total
            $order->update([
                'grand_total' => $total + $order->shipping_cost,
            ]);
        }
    }

    /**
     * Test product listing query performance.
     */
    public function test_product_listing_query_performance(): void
    {
        // Start measuring time
        $startTime = microtime(true);

        // Execute a query to get products with pagination
        $products = Product::with(['category', 'brand'])
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // Calculate execution time
        $executionTime = microtime(true) - $startTime;

        // Log the execution time
        $this->logPerformance('Product Listing Query', $executionTime);

        // Assert that the query executes in less than 0.5 seconds
        $this->assertLessThan(0.5, $executionTime, "Product listing query took too long to execute: {$executionTime} seconds");

        // Assert that we have products
        $this->assertNotEmpty($products);
    }

    /**
     * Test product search query performance.
     */
    public function test_product_search_query_performance(): void
    {
        // Start measuring time
        $startTime = microtime(true);

        // Execute a search query
        $products = Product::where('name', 'like', '%pro%')
            ->orWhere('description', 'like', '%pro%')
            ->with(['category', 'brand'])
            ->limit(24)
            ->get();

        // Assert that we have products
        $this->assertNotEmpty($products);

        // Calculate execution time
        $executionTime = microtime(true) - $startTime;

        // Log the execution time
        $this->logPerformance('Product Search Query', $executionTime);

        // Assert that the query executes in less than 0.5 seconds
        $this->assertLessThan(0.5, $executionTime, "Product search query took too long to execute: {$executionTime} seconds");
    }

    /**
     * Test product detail query performance.
     */
    public function test_product_detail_query_performance(): void
    {
        // Get a random product
        $product = Product::inRandomOrder()->first();

        if (! $product) {
            $this->markTestSkipped('No products available for testing');
        }

        // Start measuring time
        $startTime = microtime(true);

        // Execute a query to get product details
        $productDetail = Product::with(['category', 'brand'])
            ->where('id', $product->id)
            ->first();

        // Calculate execution time
        $executionTime = microtime(true) - $startTime;

        // Log the execution time
        $this->logPerformance('Product Detail Query', $executionTime);

        // Assert that the query executes in less than 0.2 seconds
        $this->assertLessThan(0.2, $executionTime, "Product detail query took too long to execute: {$executionTime} seconds");

        // Assert that we have the product
        $this->assertNotNull($productDetail);
    }

    /**
     * Test complex query execution time.
     */
    public function test_complex_query_execution_time(): void
    {
        // Start measuring time
        $startTime = microtime(true);

        // Execute a complex query
        $result = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->select('products.*', 'categories.name as category_name', 'brands.name as brand_name')
            ->where('products.is_active', true)
            ->where('products.in_stock', true)
            ->orderBy('products.created_at', 'desc')
            ->limit(100)
            ->get();

        // Assert that we have results
        $this->assertNotEmpty($result);

        // Calculate execution time
        $executionTime = microtime(true) - $startTime;

        // Log the execution time
        $this->logPerformance('Complex Query Execution', $executionTime);

        // Assert that the query executes in less than 0.5 seconds
        $this->assertLessThan(0.5, $executionTime, "Complex query took too long to execute: {$executionTime} seconds");
    }

    /**
     * Test memory usage during high-load operations.
     */
    public function test_memory_usage_during_high_load(): void
    {
        // Record initial memory usage
        $initialMemory = memory_get_usage();

        // Perform a high-load operation
        $products = Product::with(['category', 'brand'])->limit(500)->get();

        // Assert that we have products
        $this->assertNotEmpty($products);

        // Record peak memory usage
        $peakMemory = memory_get_peak_usage() - $initialMemory;

        // Convert to MB for readability
        $peakMemoryMB = $peakMemory / 1024 / 1024;

        // Log the memory usage
        $this->logPerformance('Memory Usage (High Load)', $peakMemoryMB, 'MB');

        // Assert that memory usage is less than 100MB
        $this->assertLessThan(100, $peakMemoryMB, "Memory usage too high: {$peakMemoryMB} MB");
    }

    /**
     * Test order listing query performance.
     */
    public function test_order_listing_query_performance(): void
    {
        // Start measuring time
        $startTime = microtime(true);

        // Execute a query to get orders with relationships
        $orders = Order::with(['user', 'items.product', 'address'])
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        // Assert that we have orders
        $this->assertNotEmpty($orders);

        // Calculate execution time
        $executionTime = microtime(true) - $startTime;

        // Log the execution time
        $this->logPerformance('Order Listing Query', $executionTime);

        // Assert that the query executes in less than 1 second
        $this->assertLessThan(1.0, $executionTime, "Order listing query took too long to execute: {$executionTime} seconds");
    }

    /**
     * Helper method to log performance metrics.
     */
    private function logPerformance(string $operation, float $value, string $unit = 'seconds'): void
    {
        echo "\n[PERFORMANCE] {$operation}: {$value} {$unit}";
    }
}
