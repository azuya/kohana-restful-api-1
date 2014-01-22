<?php defined('SYSPATH') OR die('No direct script access.');

class Kohana_Controller_Restful_Api extends Controller {

	public function action_index()
	{
		$api = new RESTful_API($this->request, $this->response);
		$api->execute();
		$this->response = $api->response;
	}
}
