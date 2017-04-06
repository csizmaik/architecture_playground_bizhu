<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 4/3/2017
 * Time: 12:55 PM
 */

namespace services\internal\user;

use PHPUnit\Framework\TestCase;

class LoginNameValidatorTest extends TestCase
{
	const VALID_LOGINNAME = 'norbi';
	const TOO_SHORT_LOGINNAME = 'aa';

	public function testValidLoginName()
	{
		LoginNameValidator::validate(self::VALID_LOGINNAME);
		$this->assertTrue(true);
	}

	public function testTooShortLoginName()
	{
		$this->expectException(\InvalidArgumentException::class);
		LoginNameValidator::validate(self::TOO_SHORT_LOGINNAME);
	}
}
