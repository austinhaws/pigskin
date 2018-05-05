<?php

namespace App\WebAPI\Models;

class Player extends BaseModel
{
	/** @var string Position enum */
	public $position;

	/** @var int bonus on run plays */
	public $runSkill;
	/** @var int bonus on pass plays */
	public $passSkill;
	/** @var int bonus on special teams (kickers, punters) */
	public $specialSkill;

	/** @var string how good this player is overall (A-F) */
	public $rating;

	/** @var int how old the player is */
	public $age;
}