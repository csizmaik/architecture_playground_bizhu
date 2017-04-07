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
	const TOO_SHORT_LOGIN = "a";
	const GOOD_PASS = "secret";
	const WRONG_PASS = "wrongpass";
	const EMPTY_PASS = "";

	public function testUserWithTooShortLoginName()
	{
		$this->expectException(\InvalidArgumentException::class);
		User::createWithData(1,"Csizmarik Norbert",self::TOO_SHORT_LOGIN,self::GOOD_PASS);
	}

	public function testUserWithEmptyPasswordName()
	{
		$this->expectException(\InvalidArgumentException::class);
		User::createWithData(1,"Csizmarik Norbert","norbi",self::EMPTY_PASS);
	}

	public function testValidCredentialValidation()
	{
		$user = $this->getAUser();
		$credentialValidationResult = $user->validateCredential(self::GOOD_PASS);
		$this->assertTrue($credentialValidationResult->isSuccess());
	}

	public function testFailedCredentialValidationWithWrongPassword()
	{
		$user = $this->getAUser();
		$credentialValidationResult = $user->validateCredential(self::WRONG_PASS);
		$this->assertFalse($credentialValidationResult->isSuccess());
	}

	public function testFailedCredentialValidationForInactiveUser()
	{
		$user = $this->getAUser();
		$user->deactivate();
		$credentialValidationResult = $user->validateCredential(self::GOOD_PASS);
		$this->assertFalse($credentialValidationResult->isSuccess());
	}

	public function testFailedCredentialValidationAfterTooMuchUnsuccess()
	{
		$user = $this->getAUser();
		$this->doAnUnsuccessLoginWithotException($user);
		$this->doAnUnsuccessLoginWithotException($user);
		$this->doAnUnsuccessLoginWithotException($user);
		$credentialValidationResult = $user->validateCredential(self::GOOD_PASS);
		$this->assertFalse($credentialValidationResult->isSuccess());
	}

	public function testUserActivation()
	{
		$user = $this->getAUser();
		$user->deactivate();
		$user->activate();
		$credentialValidationResult = $user->validateCredential(self::GOOD_PASS);
		$this->assertTrue($credentialValidationResult->isSuccess());
	}

	public function resetUnsuccessLoginCounter()
	{
		$user = $this->getAUser();
		$this->doAnUnsuccessLoginWithotException($user);
		$this->doAnUnsuccessLoginWithotException($user);
		$this->doAnUnsuccessLoginWithotException($user);
		$user->resetUnsuccessLoginCounter();
		$credentialValidationResult = $user->validateCredential(self::GOOD_PASS);
		$this->assertTrue($credentialValidationResult->isSuccess());
	}

	private function getAUser()
	{
		return User::createWithData(1,"Csizmarik Norbert","norbi",self::GOOD_PASS);
	}

	private function doAnUnsuccessLoginWithotException(User $user)
	{
		$credentialValidationResult = $user->validateCredential(self::WRONG_PASS);
		$user->registerCredentialValidationResult($credentialValidationResult->isSuccess(), new \DateTime("now"));
	}
}
