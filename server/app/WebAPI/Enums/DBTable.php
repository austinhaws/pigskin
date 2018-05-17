<?php

namespace App\WebAPI\Enums;

class DBTable extends BaseEnum {
	public const ACCOUNT = 'account';
	public const ACCOUNT_WORD = 'account_word';
	public const CHART = 'chart';
	public const CHART_DETAIL = 'chart_detail';
	public const DRAFT = 'draft';
	public const DRAFT_X_TEAM = 'draft_x_team';
	public const NAME = 'name';
	public const TEAM = 'team';

	static function who()
	{
		return __CLASS__;
	}
}