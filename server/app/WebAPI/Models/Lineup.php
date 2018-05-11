<?php

namespace App\WebAPI\Models;

class Lineup extends BaseModel
{
	/** @var string name */
	public $name;

	/** @var String[] guids of the players on this lineup; must be valid guids from the team's player list */
	public $playerGuids;

	/** @var String PositionType... enum of type of positions that are in this lineup */
	public $positionType;
}