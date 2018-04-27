<?php

namespace App\WebAPI\Services;

class ResponseService extends BaseService
{

	/**
	 * pull common sensitive fields out of the record like id
	 *
	 * @param $record object the record that may have sensitive data
	 * @param array $additionalFields other fields to also clear
	 * @return object the object without common sensitive fields
	 */
	public function cleanRecord($record, $additionalFields = []) {
		foreach (array_merge($additionalFields, ['id']) as $field) {
			unset($record->{$field});
		}

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