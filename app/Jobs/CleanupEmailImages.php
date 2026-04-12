<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CleanupEmailImages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
   public function handle()
{
    $files = Storage::disk('public')->files('email_images');
    foreach ($files as $file) {
        // Delete files older than 30 days
        if (Storage::disk('public')->lastModified($file) < now()->subDays(30)->getTimestamp()) {
            Storage::disk('public')->delete($file);
        }
    }
}
}