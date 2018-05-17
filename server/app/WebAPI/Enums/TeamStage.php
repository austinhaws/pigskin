<?php

namespace App\WebAPI\Enums;

class TeamStage extends BaseEnum {
	public const DRAFT = 'draft';
	public const SEASON = 'season';

	static function who()
	{
		return __CLASS__;
	}
}
