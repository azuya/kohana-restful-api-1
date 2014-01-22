<?php defined('SYSPATH') OR die('No direct script access.');

class Kohana_RESTful_API_Request {

	public function __construct(Request $request)
	{

	}

	public function execute()
	{

	}

	public function body()
	{

	}

	public function __toString()
	{
		return $this->body();
	}
}
