<?php
namespace App\WebAPI\Models;

class DraftSequence
{
	public $teamGuid;
	public $playerPickedGuid;

	/**
	 * @param $teamGuid string
	 * @param $playerPickedGuid string
	 */
	public function __construct($teamGuid, $playerPickedGuid) {
		$this->teamGuid = $teamGuid;
		$this->playerPickedGuid = $playerPickedGuid;
	}
}
