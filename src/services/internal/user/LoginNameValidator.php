<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 3/24/2017
 * Time: 4:53 PM
 */

namespace services\internal\user;


class LoginNameValidator
{
	public static function validate($loginName)
	{
		if (strlen($loginName) < 3)
		{
			throw new \InvalidArgumentException("The loginname must be longer than 3 characters");
		}
	}
}