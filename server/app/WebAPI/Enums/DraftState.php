<?php

namespace App\WebAPI\Enums;

class DraftState extends BaseEnum {
	public const IN_PROGRESS = 'in_progress';

	static function who()
	{
		return __CLASS__;
	}
}