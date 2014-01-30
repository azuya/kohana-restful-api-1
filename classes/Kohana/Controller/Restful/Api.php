<?php defined('SYSPATH') OR die('No direct script access.');

class Kohana_Controller_Restful_Api extends Controller {

	public $status_code;
	public $status_message;
	public $body;
	public $messages = array();

	protected $_restful_api_config;

	public function before()
	{
		parent::before();

		$this->_restful_api_config = Kohana::$config->load('restful_api');

		if (class_exists('Debugtoolbar'))
		{
			Debugtoolbar::disable();
		}
	}

	public function after()
	{
		try
		{
			$content_type = Arr::get(
				$this->_restful_api_config['content_type'],
				$this->request->param('format'),
				$this->_restful_api_config['content_type_default']
			);

			$this->response->headers('Content-Type', $content_type);

			$response_class = Arr::get($this->_restful_api_config['format_map'], $this->request->param('format'), FALSE);
			$response = new $response_class(array(
				'status_code' 		=> $this->status_code,
				'status_message' 	=> $this->status_message,
				'body' 				=> ($this->body) ? $this->body : $this->response->body(),
				'messages' 			=> $this->messages,
			));

			$this->response->body($response->render());
		}
		catch (Kohana_Exception $e)
		{
			$this->response->body(Kohana_Exception::text($e));
		}

		parent::after();
	}
}
