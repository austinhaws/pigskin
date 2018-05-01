<?php

namespace App\WebAPI\Test\Services;

class PlayerServiceTest extends BaseServiceTest
{
    public function testCreatePlayer()
    {
    	$phrase = $this->webApiTest->phraseService->getRandomPhrase();
    	$this->assertEquals(1, preg_match('/^[A-Z]+[A-Z]+\d\d$/i', $phrase), $phrase);
    }
}
