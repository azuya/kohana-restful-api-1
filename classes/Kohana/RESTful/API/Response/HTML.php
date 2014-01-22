<?php defined('SYSPATH') OR die('No direct script access.');

class Kohana_RESTful_API_Response_HTML extends RESTful_API_Response {

	public function render()
	{
		$response = NULL;
		$data = $this->data();

		foreach ($data as $key => $val)
		{
			$val = ($val === FALSE) ? 'FALSE' : $val;
			$val = ($val === NULL) ? 'NULL' : $val;
			$response .= $key.'|'.$val.'||';
		}

		return UTF8::trim($response, '||');
		// return implode('||', $this->data());
	}
}
