<?php defined('SYSPATH') OR die('No direct script access.');

class Kohana_RESTful_API_Exception extends Kohana_Exception {

	/**
	 * Get exception code
	 *
	 * @param   Exception  $e
	 * @return  integer
	 */
	public static function code(Exception $e)
	{
		return $e->getCode();
	}

	/**
	 * Get exception message
	 *
	 * @param   Exception  $e
	 * @return  string
	 */
	public static function text(Exception $e)
	{
		return $e->getMessage();
	}
}
