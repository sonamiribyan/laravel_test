<?php

namespace App\Jobs;


use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\DemoTest;

class ProcessDemoTestRecord implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $payload;

    protected $inquiry;

    public $tries = 2;

    public function __construct($payload, $inquiry)
    {
        $this->payload = $payload;
        $this->inquiry = $inquiry;
    }

    public function handle()
    {
        try {
            DemoTest::updateOrCreate(
                ['ref' => $this->payload['ref']],
                [
                    'name' => $this->payload['name'],
                    'description' => $this->payload['description'],
                    'status' => isset($this->payload['ref']) ? 'UPDATED' : 'NEW',
                    'is_active' => true,
                ]
            );

            $this->updateInquiryStatus('PROCESSED');
            $this->incrementItemsProcessedCount();
        } catch (\Exception $e) {
            $this->updateInquiryStatus('FAILED');
            $this->incrementItemsFailedCount();

            throw $e;
        }
    }


    protected function updateInquiryStatus($status)
    {
        $this->inquiry->status = $status;
        $this->inquiry->save();
    }

    protected function incrementItemsProcessedCount()
    {
        $this->inquiry->items_processed_count++;
        $this->inquiry->save();
    }

    protected function incrementItemsFailedCount()
    {
        // Check if it's the first attempt
        if ($this->attempts() === 1) {
            $this->inquiry->items_failed_count++;
            $this->inquiry->save();
        }
    }
}
