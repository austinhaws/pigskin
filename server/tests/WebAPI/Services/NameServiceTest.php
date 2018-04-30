<?php

use App\WebAPI\WebAPI;

class NameServiceTest extends TestCase
{
    public function testPhrase()
    {
    	$webApi = new WebAPI();

    	$phrase = $webApi->nameService->getRandomName();
    	$this->assertEquals(1, preg_match('/^[A-Z]+ [A-Z]+$/i', $phrase), $phrase);
    }
}
