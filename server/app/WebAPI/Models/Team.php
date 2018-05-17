<?php

namespace App\WebAPI\Models;

class Team extends BaseModel
{
	/** @var int */
	public $id;
	/** @var int */
	public $accountId;
	/** @var string */
	public $guid;
	/** @var string */
	public $name;
	/** @var Player[] */
	public $players;
	/** @var Lineup[] */
	public $lineups;
	/** @var string TeamType... */
	public $teamType;
	/** @var string TeamStage... */
	public $stage;
}
