<?php defined('SYSPATH') OR die('No direct script access.');

class Kohana_RESTful_API {

	/**
	 * @param object $request 		// instance of class Request
	 * @param object $response		// instance of class Request
	 * @return object 				// new instance of this class
	 */
	public static function factory(Request $request, Response $response)
	{
		return new static($request, $response);
	}

	/**
	 * @var array
	 */
	public $config;

	/**
	 * Instance of class Request
	 *
	 * @var object
	 */
	public $request;

	/**
	 * Instance of class Response
	 *
	 * @var object
	 */
	public $response;

	/**
	 * Class constructor
	 *
	 * @param object $request 		// instance of class Request
	 * @param object $response		// instance of class Request
	 * @return void
	 */
	public function __construct(Request $request, Response $response)
	{
		$this->config 	= Kohana::$config->load('restful_api')->as_array();
		$this->request 	= $request;
		$this->response = $response;

		$this->_overwrite_method();
	}

	/**
	 * Gets request params
	 *
	 * @return array
	 */
	public function params()
	{
		$params = array(
			'id' 				=> $this->request->param('id'),
			'related_id' 		=> $this->request->param('rel_id'),
			'related_resource' 	=> $this->request->param('rel_resource'),
		);

		return Arr::merge($this->request->query(), $this->request->post(), $params);
	}

	/**
	 * Performs the API call and sends response
	 *
	 * @return $this
	 */
	public function execute()
	{
		if (class_exists('Debugtoolbar'))
		{
			Debugtoolbar::disable();
		}

		$response = $this->_request();
		$this->_response($response);

		return $this;
	}

	/**
	 * Implements support for setting the request method via a GET parameter.
	 * @see https://blog.apigee.com/detail/restful_api_design_tips_for_handling_exceptional_behavior
	 *
	 * @retunr void
	 */
	protected function _overwrite_method()
	{
		if (HTTP_Request::GET == $this->request->method() AND ($method = $this->request->param('http_method')))
		{
			switch (strtoupper($method))
			{
				case HTTP_Request::POST:
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

	/**
	 * Call API
	 *
	 * @return mixed
	 */
	protected function _request()
	{
		$class = '\API\\'.$this->request->param('version').'\\'.UTF8::ucfirst($this->request->param('resource'));

		if (class_exists($class))
		{
			$params = Arr::merge($this->request->query(), $this->request->post(), $this->request->param());
			$api 	= new $class();
			$method = (array_key_exists($this->request->method(), $this->config['action_map']))
				? $this->config['action_map'][$this->request->method()]
				: $this->config['action_map']['default_action'];

			if (method_exists($api, $method))
			{
				return $api->{$method}($this->params());
			}

			throw new RESTful_API_Exception('Requested action not implemented', 501);
		}

		throw new RESTful_API_Exception('Requested resource not found', 404);
	}

	/**
	 * Sets response
	 *
	 * @param mixed $data
	 * @return void
	 */
	protected function _response($data = NULL)
	{
		$this->response->headers('Content-Type', Arr::get($this->config['content_type'], $this->request->param('format'), $this->config['content_type_default']));

		$response_class = Arr::get($this->config['format_map'], $this->request->param('format'), FALSE);

		if ( ! $response_class OR ! class_exists($response_class))
		{
			throw new RESTful_API_Exception('Unsupported response format '.$this->request->param('format'), 501);
		}

		$response = new $response_class($data);
		$this->response->body($response->render());
	}
}
