<?php

namespace App\WebAPI\Dao;

use App\WebAPI\Enums\DBTable;
use App\WebAPI\Enums\DraftState;
use Illuminate\Support\Facades\DB;

class DraftDao extends BaseDao
{
	/**
	 * @param array $draft the draft to create
	 * @return int
	 */
	public function insertDraft(array $draft) {
		return DB::table(DBTable::DRAFT)->insertGetId($draft);
	}

	/**
	 * @param $teamId int
	 * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|null|object
	 */
	public function selectDraftForTeam($teamId) {
		return DB::table(DBTable::DRAFT)
			->join(DBTable::DRAFT_X_TEAM, 'draft_x_team.draftId', '=', 'draft.id')
			->where('draft_x_team.teamId', $teamId)
			->whereRaw("draft.state = ?", [DraftState::IN_PROGRESS])
			->select('draft.*')
			->first();
	}

	/**
	 * @param array $draft
	 */
	public function updateDraft(array $draft) {
		DB::table(DBTable::DRAFT)
			->where('id', $draft['id'])
			->update([
				'availablePlayers' => $draft['availablePlayers'],
				'draftSequence' => $draft['draftSequence'],
			]);
	}

	/**
	 * @param $draftId int
	 * @param $teamId int
	 */
	public function insertDraftXTeam($draftId, $teamId) {
		DB::table(DBTable::DRAFT_X_TEAM)->insert(['draftId' => $draftId, 'teamId' => $teamId]);
	}

	/**
	 * get all team DB objects that are participating in a draft
	 * @param $draftId int
	 * @return \Illuminate\Support\Collection
	 */
	public function teamsForDraft($draftId) {
		return DB::table(DBTable::TEAM)
			->join('draft_x_team', 'draft_x_team.teamId', '=', 'team.id')
			->where('draft_x_team.draftId', $draftId)
			->get();
	}
}