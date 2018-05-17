<?php

namespace App\WebAPI\Test\Services;

class GuidServiceTest extends BaseServiceTest
{
    public function testGuid()
    {
    	$guid = $this->webApiTest->guidService->getNewGUID();
    	$this->assertTrue($this->typeCompare->isGuid($guid), $guid);
    }
}
