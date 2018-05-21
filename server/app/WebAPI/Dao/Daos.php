<?php

namespace App\WebAPI\Dao;


class Daos
{
	/** @var AccountDao */
	public $account;
	/** @var AccountWordDao */
	public $accountWord;
	/** @var ChartDao */
	public $chart;
	/** @var DraftDao */
	public $draft;
	/** @var TeamDao */
	public $team;
	/** @var NameDao */
	public $name;

	public function __construct()
	{
		$this->account = new AccountDao();
		$this->accountWord = new AccountWordDao();
		$this->chart = new ChartDao();
		$this->draft = new DraftDao();
		$this->name = new NameDao();
		$this->team = new TeamDao();
	}
}
