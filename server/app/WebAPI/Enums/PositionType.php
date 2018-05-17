<?php

namespace App\WebAPI\Enums;

class PositionType extends BaseEnum {
	public const OFFENSE = 'Offense';
	public const DEFENSE = 'Defense';
	public const KICK = 'Kick';

	static function who()
	{
		return __CLASS__;
	}
}
