<?php

namespace App\WebAPI;

use App\WebAPI\Dao\ChartDao;
use App\WebAPI\Dao\DraftDao;
use App\WebAPI\Dao\TeamDao;
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
use App\WebAPI\Services\Router\RouterService;
use App\WebAPI\Services\TeamService;
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

	/** @var ChartDao */
	public $chartDao;
	/** @var DraftDao */
	public $draftDao;
	/** @var TeamDao */
	public $teamDao;

	/** @var DraftTranslator */
	public $draftTranslator;
	/** @var TeamTranslator */
	public $teamTranslator;


	public function __construct()
	{
		// == Services == //
		$this->accountService = new AccountService($this);
		$this->chartService = new ChartService($this);
		$this->draftCPUPickService = new DraftCPUPickService($this);
		$this->draftCreateService = new DraftCreateService($this);
		$this->draftPlayerPickService = new DraftPlayerPickService($this);
		$this->draftService = new DraftService($this);
		$this->guidService = new GuidService($this);
		$this->jsonService = new JsonService($this);
		$this->nameService = new NameService($this);
		$this->phraseService = new PhraseService($this);
		$this->playerService = new PlayerService($this);
		$this->responseService = new ResponseService($this);
		$this->rollService = new RollService($this);
		$this->routerService = new RouterService($this);
		$this->teamService = new TeamService($this);

		// == DAOs == //
		$this->chartDao = new ChartDao();
		$this->draftDao = new DraftDao();
		$this->teamDao = new TeamDao();

		// == Translators == //
		$this->draftTranslator = new DraftTranslator($this);
		$this->teamTranslator = new TeamTranslator($this);
	}
}
