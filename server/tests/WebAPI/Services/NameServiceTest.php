<?php

namespace App\WebAPI\Test\Services;

class NameServiceTest extends BaseServiceTest
{
    public function testPhrase()
    {
    	$phrase = $this->webApiTest->nameService->getRandomName();
    	$this->assertEquals(1, preg_match('/^[A-Z]+ [A-Z]+$/i', $phrase), $phrase);
    }
}
