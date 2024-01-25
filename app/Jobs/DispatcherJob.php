<?php

namespace App\Jobs;

use App\Models\DemoTestInquiry;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;
use Throwable;
use Illuminate\Bus\Batch;

class DispatcherJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $inquiryId;
    /**
     * Create a new job instance.
     */
    public function __construct($inquiryId)
    {
        $this->inquiryId = $inquiryId;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $inquiry = DemoTestInquiry::find($this->inquiryId);
        $payload = $inquiry->payload;

        // Create an array to store the jobs
        $jobs = [];

        foreach ($payload as $record) {
            $job = new ProcessDemoTestRecord($record,$inquiry);
            $jobs[] = $job->onQueue('demoQueue');
        }

        Bus::batch($jobs)->dispatch();
    }
}
