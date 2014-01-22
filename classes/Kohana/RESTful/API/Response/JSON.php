<?php defined('SYSPATH') OR die('No direct script access.');

class Kohana_RESTful_API_Response_JSON extends RESTful_API_Response {

	public function render()
	{
		return json_encode($this->data());
	}
}
