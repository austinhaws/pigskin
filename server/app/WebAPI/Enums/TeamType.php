<?php

namespace App\WebAPI\Enums;

class TeamType extends BaseEnum {
	public const CPU = 'cpu';
	public const PLAYER = 'player';

	static function who()
	{
		return __CLASS__;
	}
}
