<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 4/4/2017
 * Time: 12:56 PM
 */

namespace services\internal\user;


class Authentication
{
	const MAX_UNSUCCESS_LOGIN = 3;

	private $loginName;
	private $password;
	private $unsuccessLoginCount;
	private $active;

	public static function createForUserData($loginName, $password, $unsuccessLoginCount, $active)
	{
		return new static($loginName, $password, $unsuccessLoginCount, $active);
	}

	public function __construct($loginName, $password, $unsuccessLoginCount, $active)
	{
		$this->loginName = $loginName;
		$this->password = $password;
		$this->unsuccessLoginCount = $unsuccessLoginCount;
		$this->active = $active;
	}

	public function checkLoginWithPassword($password)
	{
		if ($this->isMaxUnsuccessLoginReached())
		{
			throw new \InvalidArgumentException("Maximum unsuccess login reached!");
		}
		if (!$this->isPasswordMatch($password))
		{
			throw new \InvalidArgumentException("Wrong password");
		}
		if (!$this->isActive())
		{
			throw new \InvalidArgumentException("Wrong password");
		}
	}

	private function isPasswordMatch($password)
	{
		return ($password == $this->password);
	}

	private function isMaxUnsuccessLoginReached()
	{
		return (self::MAX_UNSUCCESS_LOGIN <= $this->unsuccessLoginCount);
	}

	private function isActive()
	{
		return ($this->active == 1);
	}

}