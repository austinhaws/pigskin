<?php

namespace App\WebAPI\Enums;

interface Position {
	public const QUARTER_BACK = 'QB';
	public const WIDE_RECEIVER = 'WR';
	public const HALF_BACK = 'HB';
	public const FULL_BACK = 'FB';
	public const TIGHT_END = 'TE';
	public const OFFENSIVE_LINE = 'OL';

	public const DEFENSIVE_LINE = 'DL';
	public const LINE_BACKER = 'LB';
	public const CORNER_BACK = 'CB';
	public const SAFETY = 'S';
	public const PUNTER = 'P';
	public const KICKER = 'K';
}
