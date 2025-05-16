<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OptimizePerformance extends Command
{
    protected $signature = 'optimize:performance';
    protected $description = 'Optimize database performance by adding indexes';

    public function handle()
    {
        $this->info('Starting performance optimization...');
        
        // Add indexes to improve query performance
        $this->addIndexes();
        
        // Run ANALYZE on tables to update statistics
        $this->analyzeDatabase();
        
        $this->info('Performance optimization completed successfully!');
        
        return Command::SUCCESS;
    }
    
    protected function addIndexes()
    {
        $this->info('Adding indexes to improve query performance...');
        
        // Products table indexes
        $this->addIndexIfNotExists('products', 'is_active');
        $this->addIndexIfNotExists('products', 'is_featured');
        $this->addIndexIfNotExists('products', 'in_stock');
        $this->addIndexIfNotExists('products', 'on_sale');
        $this->addIndexIfNotExists('products', 'price');
        $this->addIndexIfNotExists('products', 'slug', true);
        
        // Orders table indexes
        $this->addIndexIfNotExists('orders', 'status');
        $this->addIndexIfNotExists('orders', 'payment_status');
        $this->addIndexIfNotExists('orders', 'payment_method');
        $this->addIndexIfNotExists('orders', 'created_at');
        
        // Categories table indexes
        $this->addIndexIfNotExists('categories', 'is_active');
        $this->addIndexIfNotExists('categories', 'slug', true);
        
        // Brands table indexes
        $this->addIndexIfNotExists('brands', 'is_active');
        $this->addIndexIfNotExists('brands', 'slug', true);
        
        // Order items table indexes
        $this->addIndexIfNotExists('order_items', 'product_id');
    }
    
    protected function addIndexIfNotExists($table, $column, $unique = false)
    {
        $indexName = $unique ? "unique_{$table}_{$column}" : "index_{$table}_{$column}";
        
        if (Schema::hasTable($table) && Schema::hasColumn($table, $column)) {
            // Check if index already exists
            $indexes = DB::select("SHOW INDEX FROM {$table} WHERE Column_name = '{$column}'");
            
            if (empty($indexes)) {
                $this->info("Adding " . ($unique ? 'unique ' : '') . "index on {$table}.{$column}");
                
                Schema::table($table, function ($table) use ($column, $unique) {
                    if ($unique) {
                        $table->unique($column);
                    } else {
                        $table->index($column);
                    }
                });
            } else {
                $this->info("Index already exists on {$table}.{$column}");
            }
        } else {
            $this->warn("Table {$table} or column {$column} does not exist");
        }
    }
    
    protected function analyzeDatabase()
    {
        $this->info('Analyzing database tables to update statistics...');
        
        $tables = ['products', 'categories', 'brands', 'orders', 'order_items', 'users'];
        
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                $this->info("Analyzing table: {$table}");
                DB::statement("ANALYZE TABLE {$table}");
            }
        }
    }
}
