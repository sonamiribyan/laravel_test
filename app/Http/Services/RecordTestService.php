<?php

namespace App\Http\Services;

use App\Models\DemoTest;
use Exception;


class RecordTestService
{
    public function activate($ref)
    {
        $testRec = DemoTest::where('ref', $ref)->first();
        if ($testRec->is_active) {
            throw new Exception('record is already active');
        }
        $testRec->is_active = true;
        $testRec->save();
    }

    public function deactivate($ref)
    {
        $testRec = DemoTest::where('ref', $ref)->first();
        if (!$testRec->is_active) {
            throw new Exception('record is already deactivated');
        }
        $testRec->is_active = false;
        $testRec->save();
    }
}
