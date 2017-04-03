<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 3/24/2017
 * Time: 5:09 PM
 */

namespace services\internal\user;


class PasswordValidator
{
	public static function validate($password)
	{
		if (empty($password))
		{
			throw new \InvalidArgumentException("The password can't be empty string");
		}
	}
}