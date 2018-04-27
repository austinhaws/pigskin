<?php

namespace App\WebAPI\Enums;

abstract class Rating {
	/** @var string BEST! */
	public const A = 'A';

	/** @var string */
	public const B = 'B';

	/** @var string */
	public const C = 'C';

	/** @var string */
	public const D = 'D';

	/** @var string */
	public const E = 'E';

	/** @var string worst...*/
	public const F = 'F';

	public static function ratings() {
		return [
			Rating::A,
			Rating::B,
			Rating::C,
			Rating::D,
			Rating::E,
			Rating::F,
		];
	}
}
