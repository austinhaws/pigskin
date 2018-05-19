<?php

namespace App\WebAPI\Services\Translator;

use App\WebAPI\Models\Draft;
use App\WebAPI\Models\DraftSequence;
use App\WebAPI\Models\Player;

class DraftTranslator extends BaseTranslator
{
	/**
	 * @param Draft $draft
	 * @return array representing the DB team
	 */
	public function toDBArray($draft) {
		return [
			'availablePlayers' => json_encode($draft->availablePlayers),
			'draftSequence' => json_encode($draft->draftSequence),
			'state' => $draft->state,
		];
	}

	/**
	 * @param \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object $draftDB
	 * @return Draft
	 */
	public function fromDBObj($draftDB)
	{
		if ($draftDB) {
			$draft = new Draft();
			$draft->id = $draftDB->id;
			$draft->availablePlayers = $this->webApi->jsonService->jsonToObjectArray($draftDB->availablePlayers, Player::class);
			$draft->draftSequence = $this->webApi->jsonService->jsonToObjectArray($draftDB->draftSequence, DraftSequence::class);
			$draft->state = $draftDB->state;
		} else {
			$draft = null;
		}

		return $draft;
	}
}
