<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 4/5/2017
 * Time: 9:28 AM
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