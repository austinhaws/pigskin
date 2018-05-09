<?php

namespace App\WebAPI\Test\Services;

class ResponseServiceTest extends BaseServiceTest
{
    public function testCleanRecord()
    {
    	$record = json_decode('{"id":"id","name":"just a test"}');

    	$record2 = $this->webApiTest->responseService->cleanRecord($record);

    	$this->assertEquals($record, $record2);
    	$this->assertFalse(isset($record->id));
    	$this->assertFalse(isset($record2->id));
    }

    public function testCleanRecordCustom()
    {
    	$record = json_decode('{"id":"id","name":"just a test","position":"QB"}');

    	$record2 = $this->webApiTest->responseService->cleanRecord($record, ['position']);

    	$this->assertEquals($record, $record2);
    	$this->assertFalse(isset($record->id));
    	$this->assertFalse(isset($record2->id));
    	$this->assertFalse(isset($record->position));
    	$this->assertFalse(isset($record2->position));
    }
}
