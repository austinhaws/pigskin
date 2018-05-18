<?php

namespace App\WebAPI\Dao;

use App\WebAPI\Enums\DBTable;
use App\WebAPI\Enums\DraftState;
use App\WebAPI\Models\Draft;
use Illuminate\Support\Facades\DB;

class DraftDao
{
	/**
	 * @param $draft Draft the draft to create
	 */
	public function insertDraft(&$draft) {
		$draft->id = DB::table(DBTable::DRAFT)->insertGetId([
			'available_players' => json_encode($draft->availablePlayers),
			'draft_sequence' => json_encode($draft->draftSequence),
			'state' => $draft->state,
		]);
	}

	/**
	 * @param $teamId int
	 * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|null|object
	 */
	public function selectDraftForTeam($teamId) {
		return DB::table(DBTable::DRAFT)
			->join(DBTable::DRAFT_X_TEAM, 'draft_x_team.draft_id', '=', 'draft.id')
			->where('draft_x_team.team_id', $teamId)
			->whereRaw("draft.state = ?", [DraftState::IN_PROGRESS])
			->select('draft.*')
			->first();
	}

	/**
	 * @param $draftId int id of the draft to get
	 * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|null|object
	 */
	public function selectDraftById($draftId) {
		return DB::table(DBTable::DRAFT)->where('id', $draftId)->first();
	}

	/**
	 * @param $draft Draft
	 */
	public function updateDraft($draft) {
		DB::table(DBTable::DRAFT)
			->where('id', $draft->id)
			->update([
				'available_players' => json_encode($draft->availablePlayers),
				'draft_sequence' => json_encode($draft->draftSequence),
			]);
	}

	/**
	 * @param $draftId int
	 * @param $teamId int
	 */
	public function insertDraftXTeam($draftId, $teamId) {
		DB::table(DBTable::DRAFT_X_TEAM)->insert(['draft_id' => $draftId, 'team_id' => $teamId]);
	}

	/**
	 * get all team DB objects that are participating in a draft
	 * @param $draftId int
	 * @return \Illuminate\Support\Collection
	 */
	public function teamsForDraft($draftId) {
		return DB::table(DBTable::TEAM)
			->join('draft_x_team', 'draft_x_team.team_id', '=', 'team.id')
			->where('draft_x_team.draft_id', $draftId)
			->get();
	}
}