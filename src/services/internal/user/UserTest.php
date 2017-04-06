<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 4/3/2017
 * Time: 11:24 AM
 */

namespace services\internal\user;


use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
	const GOOD_PASS = "secret";
	const WRONG_PASS = "wrongpass";

	public function testSuccessLogin()
	{
		$user = $this->getAUser();
		$this->doALoginWithPassword($user, self::GOOD_PASS);
		$this->assertTrue(true);
	}

	public function testFailedLoginWithWrongPassword()
	{
		$user = $this->getAUser();
		$this->expectException(\InvalidArgumentException::class);
		$this->doALoginWithPassword($user, self::WRONG_PASS);
	}

	public function testFailedLoginForInactiveUser()
	{
		$user = $this->getAUser();
		$user->deactivate();
		$this->expectException(\InvalidArgumentException::class);
		$this->doALoginWithPassword($user, self::GOOD_PASS);
	}

	public function testFailedLoginAfterTooMuchUncuccessLogin()
	{
		$user = $this->getAUser();
		$this->doAnUnsuccessLoginWithotException($user);
		$this->doAnUnsuccessLoginWithotException($user);
		$this->doAnUnsuccessLoginWithotException($user);
		$this->expectException(\InvalidArgumentException::class);
		$this->doALoginWithPassword($user, self::GOOD_PASS);

	}

	public function testLoginActivation()
	{
		$user = $this->getAUser();
		$user->deactivate();
		$user->activate();
		$this->doALoginWithPassword($user, self::GOOD_PASS);
		$this->assertTrue(true);
	}

	public function resetUnsuccessLoginCounter()
	{
		$user = $this->getAUser();
		$this->doAnUnsuccessLoginWithotException($user);
		$this->doAnUnsuccessLoginWithotException($user);
		$this->doAnUnsuccessLoginWithotException($user);
		$user->resetUnsuccessLoginCounter();
		$this->doALoginWithPassword($user, self::GOOD_PASS);
		$this->assertTrue(true);
	}

	private function getAUser()
	{
		return User::createWithData(1,"Csizmarik Norbert","norbi",self::GOOD_PASS);
	}

	private function doALoginWithPassword(User $user, $password)
	{
		$user->loginWithPasswordAt($password, new \DateTime("now"));
	}

	private function doAnUnsuccessLoginWithotException(User $user)
	{
		try {
			$this->doALoginWithPassword($user, "wrongpass");
		} catch (\InvalidArgumentException $e) {
		}
	}
}
