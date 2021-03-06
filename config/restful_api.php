<?php defined('SYSPATH') OR die('No direct script access.');

return array(

	'default_format' => 'json',

	'format_map' => array(
		'json' 	=> 'RESTful_API_Response_JSON',
		'html' 	=> 'RESTful_API_Response_HTML',
		'csv' 	=> 'RESTful_API_Response_CSV',
		'xml' 	=> 'RESTful_API_Response_XML',
	),

	'content_type_default' => 'application/json',

	'content_type' => array(
		'json' 	=> 'application/json',
		'html' 	=> 'text/html',
		'csv' 	=> 'text/csv',
		'xml' 	=> 'application/xml',
	),

	'action_map' => array(
		HTTP_Request::GET 		=> 'read',
		HTTP_Request::POST 		=> 'create',
		HTTP_Request::PUT 		=> 'update',
		HTTP_Request::DELETE 	=> 'delete',
	),

	'default_action' => 'read',


	// HTTP status codes and messages
	'http_status_messages' => array(
		// Informational 1xx
		100 => 'Continue',
		101 => 'Switching Protocols',

		// Success 2xx
		200 => 'OK',
		201 => 'Created',
		202 => 'Accepted',
		203 => 'Non-Authoritative Information',
		204 => 'No Content',
		205 => 'Reset Content',
		206 => 'Partial Content',

		// Redirection 3xx
		300 => 'Multiple Choices',
		301 => 'Moved Permanently',
		302 => 'Found', // 1.1
		303 => 'See Other',
		304 => 'Not Modified',
		305 => 'Use Proxy',
		// 306 is deprecated but reserved
		307 => 'Temporary Redirect',

		// Client Error 4xx
		400 => 'Bad Request',
		401 => 'Unauthorized',
		402 => 'Payment Required',
		403 => 'Forbidden',
		404 => 'Not Found',
		405 => 'Method Not Allowed',
		406 => 'Not Acceptable',
		407 => 'Proxy Authentication Required',
		408 => 'Request Timeout',
		409 => 'Conflict',
		410 => 'Gone',
		411 => 'Length Required',
		412 => 'Precondition Failed',
		413 => 'Request Entity Too Large',
		414 => 'Request-URI Too Long',
		415 => 'Unsupported Media Type',
		416 => 'Requested Range Not Satisfiable',
		417 => 'Expectation Failed',

		// Server Error 5xx
		500 => 'Internal Server Error',
		501 => 'Not Implemented',
		502 => 'Bad Gateway',
		503 => 'Service Unavailable',
		504 => 'Gateway Timeout',
		505 => 'HTTP Version Not Supported',
		509 => 'Bandwidth Limit Exceeded'
	),
);
