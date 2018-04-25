<?php

require_once 'services/AccountService.php';
require_once 'services/PhraseService.php';
require_once 'services/GuidService.php';
require_once 'services/ResponseService.php';

class WebAPI {
	/** @var AccountService account service */
	public $accountService;
	/** @var PhraseService phrase service */
	public $phraseService;
	/** @var GuidService guid service */
	public $guidService;
	public $responseService;

	public function __construct()
	{
		$this->accountService = new AccountService($this);
		$this->phraseService = new PhraseService($this);
		$this->guidService = new GuidService($this);
		$this->responseService = new ResponseService($this);
	}
}
