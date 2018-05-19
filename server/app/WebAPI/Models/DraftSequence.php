<?php
namespace App\WebAPI\Models;

class DraftSequence extends BaseModel
{
	public $teamGuid;
	public $playerPickedGuid;

	/**
	 * @param $teamGuid string
	 * @param $playerPickedGuid string
	 */
	public function __construct($teamGuid = null, $playerPickedGuid = null) {
		parent::__construct();
		$this->teamGuid = $teamGuid;
		$this->playerPickedGuid = $playerPickedGuid;
	}
}
