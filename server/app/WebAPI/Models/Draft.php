<?php

namespace App\WebAPI\Models;

class Draft extends BaseModel
{
	/** @var int */
	public $id;
	/** @var Player[] (json in db) array of Player */
	public $availablePlayers;
	/** @var DraftSequence[] (json in db) array of draft sequence information  */
	public $draftSequence;
	/** @var string DraftState... enum */
	public $state;
}