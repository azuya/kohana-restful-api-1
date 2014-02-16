<?php defined('SYSPATH') OR die('No direct script access.');

class Kohana_RESTful_API {

	/**
	 * @param object $route		// instance of class Route
	 * @param array $params		// current route params
	 * @param object $request	// instance of class Request
	 *
	 * @return array
	 */
	public static function run(Route $route, array $params, Request $request)
	{
		$restful_api = new static($route, $params, $request);
		return $restful_api->params;
	}

	/**
	 * Instance of class Request
	 *
	 * @var object
	 */
	public $request;

	/**
	 * Instance of class Route
	 *
	 * @var object
	 */
	public $route;

	/**
	 * Current route params
	 *
	 * @var array
	 */
	public $params = array(
		'version' 	=> 'v1',
		'resource' 	=> 'help'
	);

	/**
	 * Gets params for route
	 *
	 * @return array
	 */
	public function params()
	{
		return $this->params;
	}

	protected function __construct(Route $route, array $params, Request $request)
	{
		$this->config 	= Kohana::$config->load('restful_api');
		$this->request 	= $request;
		$this->route 	= $route;
		$this->params 	= Arr::merge($this->params, $params);

		$this->_overwrite_method();
		$this->_set_params();
	}

	/**
	 * Implements support for setting the request method via a GET parameter.
	 * @see https://blog.apigee.com/detail/restful_api_design_tips_for_handling_exceptional_behavior
	 *
	 * @retunr void
	 */
	protected function _overwrite_method()
	{
		if ((HTTP_Request::GET === $this->request->method() OR HTTP_Request::POST === $this->request->method())
			AND ($method = Arr::get($this->params, 'http_method', FALSE)))
		{
			switch (strtoupper($method))
			{
				// case HTTP_Request::POST:
				case HTTP_Request::PUT:
				case HTTP_Request::DELETE:
					$this->request->method($method);
					break;

				default:
					break;
			}
		}
		else
		{
			// Try fetching method from HTTP_X_HTTP_METHOD_OVERRIDE before falling back on the detected method.
			$this->request->method( Arr::get($_SERVER, 'HTTP_X_HTTP_METHOD_OVERRIDE', $this->request->method()) );
		}
	}

	protected function _set_params()
	{
		$controller = 'Api_'.ucfirst($this->params['version']).'_'.ucfirst($this->params['resource']);
		$action 	= Arr::get($this->config['action_map'], $this->request->method(), NULL);

		if (class_exists('Controller_'.$controller)
			AND method_exists('Controller_'.$controller, 'action_'.$action)
			AND $action != NULL)
		{
			$this->params['controller'] = $controller;
			$this->params['action'] 	= $action;
		}
		else
		{
			$action = strtolower($this->request->method());

			if ( ! method_exists('Restful_Api_Error', 'action_'.$action))
			{
				$action = 'unsupported_request_format';
			}

			$this->params['controller'] = 'Restful_Api_Error';
			$this->params['action'] 	= $action;
		}

		$response_class = Arr::get($this->config['format_map'], $this->params['format'], FALSE);

		if ( ! $response_class OR ! class_exists($response_class))
		{
			$this->request->query('requested_format', $this->params['format']);

			$this->params['controller'] = 'Restful_Api_Error';
			$this->params['action'] 	= 'unsupported_format';
			$this->params['format'] 	= $this->config['default_format'];
		}
	}
}
