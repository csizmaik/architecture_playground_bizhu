<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 4/3/2017
 * Time: 1:56 PM
 */

namespace services\internal\user;


class ReservedLoginChecker
{
	public static function check($loginNameUsed)
	{
		if ($loginNameUsed) {
			throw new \InvalidArgumentException("The login name already used");
		}
	}
}