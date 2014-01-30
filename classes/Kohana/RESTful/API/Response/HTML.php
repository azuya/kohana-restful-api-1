<?php defined('SYSPATH') OR die('No direct script access.');

class Kohana_RESTful_API_Response_HTML extends RESTful_API_Response {

	protected $_response;

	public function render()
	{
		return $this->_arr2str($this->data());
	}

	protected function _arr2str(array $data = NULL)
	{
		$response = NULL;

		if ($data != NULL)
		{
			foreach ($data as $key => $val)
			{
				$val = (is_array($val)) ? implode(';', $val) : $val;
				$val = ($val === FALSE) ? 'FALSE' : $val;
				$val = ($val == NULL) ? 'NULL' : $val;

				$response .= $key.'|'.$val.'||';
			}
		}

		return UTF8::trim($response, '||');
	}
}
