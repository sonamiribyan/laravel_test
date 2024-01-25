<?php

namespace App\Http\Services;

use App\Models\DemoTestInquiry;
use App\Jobs\DispatcherJob;
class DemoTestService
{
    public function createDemoTest(array $validatedData)
    {

        $inquiry = DemoTestInquiry::create([
            'payload' => $validatedData,
            'items_total_count' => count($validatedData),
        ]);
        DispatcherJob::dispatch($inquiry->id);
    }
}
