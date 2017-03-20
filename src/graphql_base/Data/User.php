<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 3/20/2017
 * Time: 2:04 PM
 */

namespace graphql_base\Data;


use GraphQL\Utils;

class User
{
	public $id;
	public $name;
	public $email;
	public $status;

	/**
	 * User constructor.
	 */
	public function __construct(array $data)
	{
		Utils::assign($this,$data);
	}


}