<?php

namespace App\WebAPI\Services\Translator;

use App\WebAPI\Models\Lineup;
use App\WebAPI\Models\Player;
use App\WebAPI\Models\Team;

class TeamTranslator extends BaseTranslator
{
	/**
	 * @param $team
	 * @return array representing the DB team
	 */
	public function toDBArray($team) {
		return [
			'accountId' => $team->accountId,
			'guid' => $team->guid,
			'name' => $team->name,
			'players' => json_encode($team->players),
			'lineups' => json_encode($team->lineups),
			'teamType' => $team->teamType,
			'stage' => $team->stage,
		];
	}

	/**
	 * @param \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object $teamDB
	 * @return Team
	 */
	public function fromDBObj($teamDB)
	{
		if ($teamDB) {
			$team = new Team();
			$team->id = $teamDB->id;
			$team->accountId = $teamDB->accountId;
			$team->guid = $teamDB->guid;
			$team->name = $teamDB->name;
			$team->players = $this->webApi->jsonService->jsonToObjectArray($teamDB->players, Player::class);
			$team->lineups = $this->webApi->jsonService->jsonToObjectArray($teamDB->lineups, Lineup::class);
			$team->teamType = $teamDB->teamType;
			$team->stage = $teamDB->stage;
		} else {
			$team = null;
		}

		return $team;
	}
}
