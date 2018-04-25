<?php

require_once 'BaseService.php';

class ResponseService extends BaseService
{

	/**
	 * pull common sensitive fields out of the record like id
	 *
	 * @param $record object the record that may have sensitive data
	 * @return object the object without common sensitive fields
	 */
	public function cleanRecord($record) {
		unset($record->id);
		return $record;
	}

	/**
	 * clean a record and respond with it as json
	 *
	 * @param $record object the record to clean and jsonify
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function cleanJsonResponse($record) {
		return response()->json($this->cleanRecord($record));
	}
}