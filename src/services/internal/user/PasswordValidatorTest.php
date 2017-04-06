<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 4/3/2017
 * Time: 1:01 PM
 */

namespace services\internal\user;

use PHPUnit\Framework\TestCase;

class PasswordValidatorTest extends TestCase
{
	const VALID_PASSWORD = 'secret';
	const EMPTY_PASSWORD = '';

	public function testValidPassword()
	{
		PasswordValidator::validate(self::VALID_PASSWORD);
		$this->assertTrue(true);
	}

	public function testEmptyPassword()
	{
		$this->expectException(\InvalidArgumentException::class);
		PasswordValidator::validate(self::EMPTY_PASSWORD);
	}
}
