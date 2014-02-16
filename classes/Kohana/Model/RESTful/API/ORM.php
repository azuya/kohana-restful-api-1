<?php defined('SYSPATH') OR die('No direct script access.');

class Kohana_Model_RESTful_API_ORM extends ORM {

	/**
	 * Gets model data
	 *
	 * @param integer $id
	 * @return array
	 */
    public function find_all_as_array()
    {
		$data = $this->find_all()->as_array();
		return (count($data) > 0) ? array_map(array($this, 'obj_to_arr'), $data) : NULL;
	}

	public function obj_to_arr(ORM $obj)
	{
		return $obj->as_array();
	}
}
