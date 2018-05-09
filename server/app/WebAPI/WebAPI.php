<?php

namespace App\WebAPI;

use App\WebAPI\Services\AccountService;
use App\WebAPI\Services\ChartService;
use App\WebAPI\Services\GuidService;
use App\WebAPI\Services\JsonService;
use App\WebAPI\Services\NameService;
use App\WebAPI\Services\PhraseService;
use App\WebAPI\Services\PlayerService;
use App\WebAPI\Services\ResponseService;
use App\WebAPI\Services\RollService;
use App\WebAPI\Services\TeamService;

class WebAPI {
	/** @var AccountService account service */
	public $accountService;
	/** @var ChartService chart service */
	public $chartService;
	/** @var GuidService guid service */
	public $guidService;
	/** @var JsonService json service */
	public $jsonService;
	/** @var NameService name service */
	public $nameService;
	/** @var PhraseService phrase service */
	public $phraseService;
	/** @var PlayerService phrase service */
	public $playerService;
	/** @var ResponseService response service */
	public $responseService;
	/** @var RollService roll service */
	public $rollService;
	/** @var TeamService team service */
	public $teamService;

	public function __construct()
	{
		$this->accountService = new AccountService($this);
		$this->chartService = new ChartService($this);
		$this->guidService = new GuidService($this);
		$this->jsonService = new JsonService($this);
		$this->nameService = new NameService($this);
		$this->playerService = new PlayerService($this);
		$this->phraseService = new PhraseService($this);
		$this->responseService = new ResponseService($this);
		$this->rollService = new RollService($this);
		$this->teamService = new TeamService($this);
	}
}
