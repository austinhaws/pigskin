<?php

namespace App\WebAPI\Test\Services;

class GuidServiceTest extends BaseServiceTest
{
    public function testGuid()
    {
    	$guid = $this->webApiTest->guidService->getNewGUID();
    	$this->assertEquals(1, preg_match('/^[a-z|0-9]{13}$/i', $guid), $guid);
    }
}
