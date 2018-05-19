<?php

namespace App\WebAPI\Services\Translator;


use App\WebAPI\Services\BaseService;

abstract class BaseTranslator extends BaseService
{
	/**
	 * @param $object
	 * @return array
	 */
	abstract function toDBArray($object);

	/**
	 * @param \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object $objectDB
	 * @return mixed
	 */
	abstract function fromDBObj($objectDB);

	/**
	 * convert a collection of DB objects to actual objects
	 *
	 * @param \Illuminate\Support\Collection $collectionDB
	 * @return mixed[]
	 */
	public function fromDBCollection(\Illuminate\Support\Collection $collectionDB)
	{
		$that = $this;
		return array_map(function ($objectDB) use ($that) {
			return $that->fromDBObj($objectDB);
		}, $collectionDB->toArray());
	}
}
