<?php

namespace App\WebAPI\Models;

class Account extends BaseModel
{
	/** @var int */
	public $id;
	/** @var string */
	public $phrase;
	/** @var string */
	public $guid;
}