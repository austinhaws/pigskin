<?php

namespace App\WebAPI\Test\Services\Utility;

class TypesCompare
{
	/**
	 * @param $guid string the guid to check
	 * @return bool true if the guid is a guid
	 */
    public function isGuid($guid)
    {
    	return 1 === preg_match('/^[a-z|0-9]{13}$/i', $guid);
    }
}
