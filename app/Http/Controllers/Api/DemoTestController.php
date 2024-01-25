<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Demo\DemoTestStoreRequest;
use App\Http\Services\DemoTestService;
use App\Models\DemoTest;

class DemoTestController extends Controller
{
    public function __construct(
        private readonly DemoTestService $demoTestService,
    ) {
    }

    public function create(DemoTestStoreRequest $demoTestStoreRequest)
    {
        $demoData = $demoTestStoreRequest->validated()['demo'];

        // Check if any record with the same ref exists and is inactive
        foreach ($demoData as $record) {
            $existingRecord = DemoTest::where('ref', $record['ref'])->where('is_active', false)->first();

            if ($existingRecord) {
                return response()->json(['error' => 'Inactive record with the same ref already exists.'], 422);
            }
        }

        $this->demoTestService->createDemoTest($demoData);

        return response()->json(['message' => 'Record created successfully'], 200);
    }
}
