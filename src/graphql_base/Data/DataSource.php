<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 3/20/2017
 * Time: 3:30 PM
 */

namespace graphql_base\Data;


class DataSource
{
	private static $users = [];

	public static function init()
	{
		self::$users = [
			'1' => new User([
				'id' => '1',
				'email' => 'john@example.com',
				'name' => 'John Doe',
				'status' => UserStatus::ACTIVE
			]),
			'2' => new User([
				'id' => '2',
				'email' => 'jane@example.com',
				'name' => 'Jane Doe',
				'status' => UserStatus::ACTIVE
			]),
			'3' => new User([
				'id' => '3',
				'email' => 'john@example.com',
				'name' => 'John Dee',
				'status' => UserStatus::INACTIVE
			]),
			'4' => new User([
				'id' => '4',
				'email' => 'csizmarik.norbert@biztositas.hu',
				'name' => 'Csizmarik Norbert',
				'status' => UserStatus::ACTIVE
			]),
		];
	}

	public static function findUser($id)
	{
		return isset(self::$users[$id]) ? self::$users[$id] : null;
	}

	public static function findLastUser()
	{
		$maxKey = max(array_keys(self::$users));
		return self::$users[$maxKey];
	}

	public static function findAllUsers($limit)
	{
		$result = [];
		foreach (self::$users as $user)
		{
			$result[] = $user;
			if (!empty($limit) && count($result) >= $limit) break;
		}
		return $result;
	}

	public static function activeUsers()
	{
		return array_filter(self::$users, function(User $user) {
			return $user->status == UserStatus::ACTIVE;
		});
	}
}