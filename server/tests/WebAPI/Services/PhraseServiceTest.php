<?php

namespace App\WebAPI\Test\Services;

class PhraseServiceTest extends BaseServiceTest
{
    public function testPhrase()
    {
    	$phrase = $this->webApiTest->phraseService->getRandomPhrase();
    	$this->assertEquals(1, preg_match('/^[A-Z][a-z]+[A-Z][a-z]+\d\d$/', $phrase), $phrase);
    }
}
