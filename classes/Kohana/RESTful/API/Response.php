<?php defined('SYSPATH') OR die('No direct script access.');

abstract class Kohana_RESTful_API_Response {

	protected $_config;

	protected $_data = array(
		'status_code' 		=> '200',
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

		$this->_config 	= Kohana::$config->load('restful_api');
		$this->_data 	= Arr::merge($this->_data, $data);

		$this->_data['status_message'] = Arr::get(
			$this->_config['http_status_messages'],
			$this->_data['status_code'],
			'Undefined'
		);
	}

	public function data()
	{
		return $this->_data;
	}

	public function __toString()
	{
		$response = $this->render();

		if (is_array($response) OR is_object($response))
		{
			$response = Debug::vars($response);
		}

		return $response;
	}
}
