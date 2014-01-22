<?php defined('SYSPATH') OR die('No direct script access.');

abstract class Kohana_RESTful_API_Response {

	protected $_data = array(
		'status' 			=> '200',
		'status_message' 	=> 'OK',
		'body' 				=> NULL,
		'messages' 			=> NULL,
	);

	abstract public function render();

	public function __construct($data = NULL)
	{
		if ( ! is_array($data))
		{
			$data = array('body' => $data);
		}

		$this->_data = Arr::merge($this->_data, $data);
	}

	public function data()
	{
		return $this->_data;
	}

	public function __toString()
	{
		return $this->render();
	}
}
