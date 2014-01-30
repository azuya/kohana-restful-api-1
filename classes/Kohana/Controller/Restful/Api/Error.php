<?php defined('SYSPATH') OR die('No direct script access.');

class Kohana_Controller_Restful_Api_Error extends Controller_Restful_Api {

	public function action_index()
	{
		$this->action_undefined();
	}

	public function action_get()
	{
		// ...
	}

	public function action_post()
	{
		// ...
	}

	public function action_put()
	{
		// ...
	}

	public function action_delete()
	{
		// ...
	}

	public function action_unsupported_format()
	{
		$this->messages = 'Unsupported response format: '.UTF8::strtoupper($this->response->query('requested_format'));
	}

	public function action_undefined()
	{
		$this->status_code = 500;
		$this->messages = 'Undefined error';
	}

	public function after()
	{
		$this->status_code 		= ($this->status_code) ? $this->status_code : 501;
		$this->status_message 	= ($this->status_message) ? $this->status_message : 'Not Implemented';
		$this->body 			= ($this->body) ? $this->body : NULL;
		$this->messages 		= (empty($this->messages))
								? array('Requested action is not available')
								: $this->messages;

		Kohana::$log->add(Log::ERROR, 'RequestedURL: '.$this->request->uri());
		Kohana::$log->add(Log::ERROR, 'ErrorMessage: '.implode('; ', $this->messages));
		Kohana::$log->add(Log::ERROR, 'ClientIP: '.Request::$client_ip);
		Kohana::$log->add(Log::ERROR, 'UserAgent: '.Request::$user_agent);

		parent::after();
	}
}
