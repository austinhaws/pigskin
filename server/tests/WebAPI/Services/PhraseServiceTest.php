<?php

use App\WebAPI\WebAPI;

class PhraseServiceTest extends TestCase
{
    public function testPhrase()
    {
    	$webApi = new WebAPI();

    	$phrase = $webApi->phraseService->getRandomPhrase();
    	$this->assertEquals(1, preg_match('/^[A-Z].*[A-Z].*\d\d$/', $phrase), $phrase);
    }
}
