<?php defined('SYSPATH') OR die('No direct script access.');

class Kohana_Controller_Restful_Api extends Controller {

	public $status_code;
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
		parent::after();
	}

	/**
	 * Executes the given action and calls the [Controller::before] and [Controller::after] methods.
	 *
	 * Can also be used to catch exceptions from actions in a single place.
	 *
	 * 1. Before the controller action is called, the [Controller::before] method
	 * will be called.
	 * 2. Next the controller action will be called.
	 * 3. After the controller action is called, the [Controller::after] method
	 * will be called.
	 *
	 * @throws  HTTP_Exception_404
	 * @return  Response
	 */
	public function execute()
	{
		try
		{
			parent::execute();
		}
		catch (Kohana_Exception $e)
		{
			$this->status_code 	= RESTful_API_Exception::code($e);
			$this->messages[] 	= RESTful_API_Exception::text($e);
		}

		$this->_response();

		// Return the response
		return $this->response;
	}

	/**
	 * Set response data
	 *
	 * @return void
	 */
	protected function _response()
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
				'status_code' 		=> ($this->status_code) ? $this->status_code : 200,
				'body' 				=> ($this->body) ? $this->body : $this->response->body(),
				'messages' 			=> $this->messages,
			));

			$this->response->body($response->render());
		}
		catch (Kohana_Exception $e)
		{
			$this->response->body(RESTful_API_Exception::text($e));
		}
	}
}
