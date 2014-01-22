<?php defined('SYSPATH') OR die('No direct script access.');

return array(

	'base_path' => DOCROOT.'../',

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
);
