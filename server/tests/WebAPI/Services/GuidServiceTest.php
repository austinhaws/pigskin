<?php

namespace App\WebAPI\Test\Services;

class GuidServiceTest extends BaseServiceTest
{
    public function testGuid()
    {
    	$guid = $this->webApiTest->guidService->getNewGUID();
    	$this->assertTrue($this->webApiTest->guidService->isGuid($guid), $guid);
    }

    public function testIsGuid() {
    	// was getting false positive with 13 length phrases
		$this->assertFalse($this->webApiTest->guidService->isGuid('SourBicycle71'));
	}
}
