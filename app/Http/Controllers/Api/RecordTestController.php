<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\RecordTestService;
use Exception;

class RecordTestController extends Controller
{
    public function __construct(
        private readonly RecordTestService $recordTestService,
    ) {}

    public function activate($ref)
    {
        try {
            $this->recordTestService->activate($ref);

            return response()->json(['message' => 'Record activated successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function deactivate($ref)
    {
        try {
            $this->recordTestService->deactivate($ref);

            return response()->json(['message' => 'Record deactivated successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
