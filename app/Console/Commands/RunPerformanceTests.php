<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class RunPerformanceTests extends Command
{
    protected $signature = 'test:performance {--report : Generate a detailed performance report}';
    protected $description = 'Run performance tests and optionally generate a report';

    public function handle()
    {
        $this->info('Starting performance tests...');
        
        // Measure database statistics before tests
        $this->info('Gathering database statistics...');
        $dbStats = $this->getDatabaseStats();
        
        // Run the performance tests
        $this->info('Running performance tests...');
        $testOutput = [];
        exec('php artisan test --filter=PerformanceTest', $testOutput, $returnCode);
        
        // Display test results
        foreach ($testOutput as $line) {
            $this->line($line);
        }
        
        // Generate report if requested
        if ($this->option('report')) {
            $this->generateReport($dbStats, $testOutput);
        }
        
        return $returnCode;
    }
    
    private function getDatabaseStats(): array
    {
        return [
            'users' => DB::table('users')->count(),
            'products' => DB::table('products')->count(),
            'categories' => DB::table('categories')->count(),
            'brands' => DB::table('brands')->count(),
            'orders' => DB::table('orders')->count(),
            'order_items' => DB::table('order_items')->count(),
        ];
    }
    
    private function generateReport(array $dbStats, array $testOutput): void
    {
        $this->info('Generating performance report...');
        
        // Create reports directory if it doesn't exist
        if (!File::exists(storage_path('reports'))) {
            File::makeDirectory(storage_path('reports'));
        }
        
        // Extract performance metrics from test output
        $performanceMetrics = [];
        foreach ($testOutput as $line) {
            if (strpos($line, '[PERFORMANCE]') !== false) {
                $performanceMetrics[] = $line;
            }
        }
        
        // Generate report content
        $reportContent = "# Performance Test Report\n\n";
        $reportContent .= "Generated at: " . now()->format('Y-m-d H:i:s') . "\n\n";
        
        $reportContent .= "## Database Statistics\n\n";
        foreach ($dbStats as $table => $count) {
            $reportContent .= "- {$table}: {$count} records\n";
        }
        
        $reportContent .= "\n## Performance Metrics\n\n";
        foreach ($performanceMetrics as $metric) {
            $reportContent .= "- " . str_replace('[PERFORMANCE] ', '', $metric) . "\n";
        }
        
        $reportContent .= "\n## System Information\n\n";
        $reportContent .= "- PHP Version: " . PHP_VERSION . "\n";
        $reportContent .= "- Memory Limit: " . ini_get('memory_limit') . "\n";
        $reportContent .= "- Max Execution Time: " . ini_get('max_execution_time') . " seconds\n";
        
        // Save report to file
        $filename = 'performance_report_' . now()->format('Y-m-d_H-i-s') . '.md';
        File::put(storage_path('reports/' . $filename), $reportContent);
        
        $this->info("Performance report saved to: storage/reports/{$filename}");
    }
}
