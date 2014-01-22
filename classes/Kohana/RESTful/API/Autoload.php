<?php defined('SYSPATH') OR die('No direct script access.');

class Kohana_RESTful_API_Autoload {

	/**
	 * @var string
	 */
	protected $_base_path;

	/**
	 * Class constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->_base_path = Kohana::$config->load('restful_api')->get('base_path');
	}

	/**
	 * Provides auto-loading support of classes
	 *
	 * @param   string  $class
	 * @return  boolean
	 */
	public function load_api_class($class)
	{
		// Transform the class name according to PSR-0
		$class     = ltrim($class, '\\');
		$file      = '';
		$namespace = '';

		if ($last_namespace_position = strripos($class, '\\'))
		{
			$namespace = substr($class, 0, $last_namespace_position);
			$class     = substr($class, $last_namespace_position + 1);
			$file      = str_replace('\\', DIRECTORY_SEPARATOR, $namespace).DIRECTORY_SEPARATOR;
		}

		$file .= str_replace('_', DIRECTORY_SEPARATOR, $class);

		if ( ! is_dir($this->_base_path))
		{
			return FALSE;
		}

		$path = $this->_base_path.DIRECTORY_SEPARATOR.$file.EXT;

		if (file_exists($path))
		{
			// Load the class file
			require $path;

			// Class has been found
			return TRUE;
		}

		// Class is not in the filesystem
		return FALSE;
	}
}
