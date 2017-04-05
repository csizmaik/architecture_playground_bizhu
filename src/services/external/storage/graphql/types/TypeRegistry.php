<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 4/3/2017
 * Time: 2:16 PM
 */

namespace services\external\storage\graphql\types;


class TypeRegistry
{
	private static $user;

	/**
	 * @return UserType
	 */
	public static function user()
	{
		return self::$user ?: (self::$user = new UserType());
	}
}