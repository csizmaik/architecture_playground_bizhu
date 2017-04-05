<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 4/5/2017
 * Time: 10:24 AM
 */

namespace services\internal\user;


use PHPUnit\Framework\TestCase;

class LoginNameValidatorTest extends TestCase
{
	const VALID_LOGINNAME = "norbi";
	const TOOSHORT_LOGINNAME = "a";

	public function testWithValidLogin()
	{
		LoginNameValidator::validate(self::VALID_LOGINNAME);
		$this->assertTrue(true);
	}

	public function testTooShortLogin()
	{
		$this->expectException(\InvalidArgumentException::class);
		LoginNameValidator::validate(self::TOOSHORT_LOGINNAME);
	}
}
