<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 4/7/2017
 * Time: 10:03 AM
 */

namespace services\internal\user;

use PHPUnit\Framework\TestCase;

class ReservedLoginCheckerTest extends TestCase
{
	const LOGIN_NAME_FREE = false;
	const LOGIN_NAME_RESERVED = true;

	public function testFreeLoginName()
	{
		$result = ReservedLoginChecker::check(self::LOGIN_NAME_FREE);
		$this->assertTrue($result);
	}

	public function testReservedLoginName()
	{
		$this->expectException(\InvalidArgumentException::class);
		ReservedLoginChecker::check(self::LOGIN_NAME_RESERVED);
	}
}
