<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 3/20/2017
 * Time: 3:18 PM
 */

namespace graphql_base;


use graphql_base\Type\UserStatusType;
use graphql_base\Type\UserType;

class Types
{
	private static $user;
	private static $userStatus;

	/**
	 * @return UserType
	 */
	public static function user()
	{
		return self::$user ?: (self::$user = new UserType());
	}

	public static function userStatus()
	{
		return self::$userStatus ?: (self::$userStatus = new UserStatusType());
	}
}