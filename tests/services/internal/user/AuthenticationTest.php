<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 4/5/2017
 * Time: 10:13 AM
 */

namespace services\internal\user;

use PHPUnit\Framework\TestCase;

class AuthenticationTest extends TestCase
{
	const TEST_LOGINNAME = "norbi";
	const TEST_PASSWORD = "secret";

	public function testSuccessAuthentication()
	{
		$auth = Authentication::createForUserData(self::TEST_LOGINNAME,self::TEST_PASSWORD,0,1);
		$auth->checkLoginWithPassword(self::TEST_PASSWORD);
		$this->assertTrue(true);
	}

	public function testFailedAuthenticationWithWrongPassword()
	{
		$auth = Authentication::createForUserData(self::TEST_LOGINNAME,self::TEST_PASSWORD,0,1);
		$this->expectException(\InvalidArgumentException::class);
		$auth->checkLoginWithPassword("wrongpass");
	}

	public function testFailedAuthenticationWithInactiveUser()
	{
		$auth = Authentication::createForUserData(self::TEST_LOGINNAME,self::TEST_PASSWORD,0,0);
		$this->expectException(\InvalidArgumentException::class);
		$auth->checkLoginWithPassword(self::TEST_PASSWORD);
	}

	public function testFailedAuthenticationAfterTooManyFailedAuth()
	{
		$auth = Authentication::createForUserData(self::TEST_LOGINNAME,self::TEST_PASSWORD,Authentication::MAX_UNSUCCESS_LOGIN,1);
		$this->expectException(\InvalidArgumentException::class);
		$auth->checkLoginWithPassword(self::TEST_PASSWORD);
	}

}
