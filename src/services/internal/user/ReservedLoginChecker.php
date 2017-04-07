<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 3/25/2017
 * Time: 8:24 AM
 */

namespace services\internal\user;


class ReservedLoginChecker
{
	public static function check($loginNameUsed)
	{
		if ($loginNameUsed) {
			throw new \InvalidArgumentException("The login name already used");
		}
		return true;
	}
}