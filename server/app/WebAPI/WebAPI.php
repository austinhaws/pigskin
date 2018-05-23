<?php

namespace App\WebAPI;

use App\WebAPI\Dao\Daos;
use App\WebAPI\Services\AccountService;
use App\WebAPI\Services\Chart\ChartService;
use App\WebAPI\Services\Draft\DraftCPUPickService;
use App\WebAPI\Services\Draft\DraftCreateService;
use App\WebAPI\Services\Draft\DraftPlayerPickService;
use App\WebAPI\Services\Draft\DraftService;
use App\WebAPI\Services\GuidService;
use App\WebAPI\Services\JsonService;
use App\WebAPI\Services\NameService;
use App\WebAPI\Services\PhraseService;
use App\WebAPI\Services\PlayerService;
use App\WebAPI\Services\ResponseService;
use App\WebAPI\Services\RollService;
use App\WebAPI\Services\RouterService;
use App\WebAPI\Services\TeamService;
use App\WebAPI\Services\Translator\AccountTranslator;
use App\WebAPI\Services\Translator\DraftTranslator;
use App\WebAPI\Services\Translator\TeamTranslator;

class WebAPI {
	/** @var AccountService account service */
	public $accountService;
	/** @var ChartService chart service */
	public $chartService;
	/** @var DraftCPUPickService */
	public $draftCPUPickService;
	/** @var DraftCreateService  */
	public $draftCreateService;
	/** @var DraftPlayerPickService  */
	public $draftPlayerPickService;
	/** @var DraftService */
	public $draftService;
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
	/** @var RouterService */
	public $routerService;
	/** @var TeamService team service */
	public $teamService;

	/** @var AccountTranslator */
	public $accountTranslator;
	/** @var DraftTranslator */
	public $draftTranslator;
	/** @var TeamTranslator */
	public $teamTranslator;


	public function __construct()
	{
		// == Services w/ DAOs == //
		$daos = new Daos();
		$this->accountService = new AccountService($this, $daos);
		$this->chartService = new ChartService($this, $daos);
		$this->draftCPUPickService = new DraftCPUPickService($this, $daos);
		$this->draftCreateService = new DraftCreateService($this, $daos);
		$this->draftPlayerPickService = new DraftPlayerPickService($this, $daos);
		$this->draftService = new DraftService($this, $daos);
		$this->guidService = new GuidService($this, $daos);
		$this->nameService = new NameService($this, $daos);
		$this->phraseService = new PhraseService($this, $daos);
		$this->playerService = new PlayerService($this, $daos);
		$this->teamService = new TeamService($this, $daos);

		// == Plain Services == //
		$this->jsonService = new JsonService($this);
		$this->responseService = new ResponseService($this);
		$this->rollService = new RollService($this);
		$this->routerService = new RouterService($this);

		// == Translators == //
		$this->accountTranslator = new AccountTranslator($this);
		$this->draftTranslator = new DraftTranslator($this);
		$this->teamTranslator = new TeamTranslator($this);
	}
}
