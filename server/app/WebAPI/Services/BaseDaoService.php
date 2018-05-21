<?php

namespace App\WebAPI\Services;

use App\WebAPI\Dao\Daos;
use App\WebAPI\WebAPI;

class BaseDaoService extends BaseService
{
	/** @var Daos all the Services available for your consumption, SIR! */
	protected $daos;

	/**
	 * BaseService constructor.
	 * @param WebAPI $webApi
	 * @param Daos $daos
	 */
	public function __construct(WebAPI $webApi, Daos $daos)
	{
		parent::__construct($webApi);
		$this->daos = $daos;
	}

}