<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CheckPaintingsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'paintings:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check paintings data and images';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking paintings data...');
        
        // Check database
        $paintings = DB::table('paintings')->get();
        $this->info('Found ' . count($paintings) . ' paintings in database.');
        
        if (count($paintings) > 0) {
            $this->info('Paintings data:');
            foreach ($paintings as $painting) {
                $this->line('ID: ' . $painting->id . ', Title: ' . $painting->title);
                $this->line('Image: ' . $painting->image);
                
                // Check if image exists
                if ($painting->image) {
                    if (Storage::disk('public')->exists($painting->image)) {
                        $this->info('Image exists: ' . $painting->image);
                        $size = Storage::disk('public')->size($painting->image);
                        $this->info('Image size: ' . $size . ' bytes');
                    } else {
                        $this->error('Image does not exist: ' . $painting->image);
                    }
                } else {
                    $this->warn('No image path for this painting.');
                }
                
                $this->newLine();
            }
        }
        
        // Check storage directory
        $this->info('Checking storage directory...');
        $files = Storage::disk('public')->files('paintings');
        $this->info('Found ' . count($files) . ' files in storage/app/public/paintings.');
        
        if (count($files) > 0) {
            $this->info('Files:');
            foreach ($files as $file) {
                $this->line($file . ' (' . Storage::disk('public')->size($file) . ' bytes)');
            }
        }
        
        return 0;
    }
}
