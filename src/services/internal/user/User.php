<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 3/25/2017
 * Time: 7:36 AM
 */

namespace services\internal\user;

use DateTime;

class User
{
	const MAX_UNSUCCESS_LOGIN = 3;
	private $id;
	private $userId;
	private $name;
	private $login;
	private $password;
	private $active = true;
	private $unsuccessLoginCount = 0;
	private $lastSuccessLogin = null;

	public static function createWithData($userId, $name, $login, $password)
	{
		return new static($userId, $name, $login, $password);
	}

	/**
	 * User constructor.
	 * @param $name
	 * @param $login
	 * @param $password
	 */
	public function __construct($userId, $name, $login, $password)
	{
		$this->userId = $userId;
		$this->setName($name);
		$this->setLogin($login);
		$this->setPassword($password);
	}

	public function loginWithPasswordAt($password, DateTime $loginTime)
	{
		if ($this->isMaxUnsuccessLoginReached())
		{
			$this->denyLogin("Maximum unsuccess login reached!");
		}
		if ($password != $this->password)
		{
			$this->denyLogin("Wrong password");
		}
		if (!$this->isActive())
		{
			$this->denyLogin("Inactive user can't login!");
		}
		$this->registerSuccessLoginAt($loginTime);
	}

	public function deactivate()
	{
		$this->active = false;
	}

	public function activate()
	{
		$this->active = true;
	}

	public function isActive()
	{
		return $this->active;
	}

	public function resetUnsuccessLoginCounter()
	{
		$this->unsuccessLoginCount = 0;
	}

	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return mixed
	 */
	public function getUserId()
	{
		return $this->userId;
	}

	/**
	 * @return mixed
	 */
	public function getLogin()
	{
		return $this->login;
	}

	public function registerSuccessLoginAt(\DateTime $loginTime)
	{
		$this->lastSuccessLogin = $loginTime;
	}

	public function registerFailedLogin()
	{
		$this->unsuccessLoginCount++;
	}

	private function setName($name)
	{
		$this->name = $name;
	}

	private function setLogin($login)
	{
		LoginNameValidator::validate($login);
		$this->login = $login;
	}

	private function setPassword($password)
	{
		PasswordValidator::validate($password);
		$this->password = $password;
	}

	private function denyLogin($denyMessage)
	{
		$this->registerFailedLogin();
		throw new \InvalidArgumentException($denyMessage);
	}

	private function isMaxUnsuccessLoginReached()
	{
		if (self::MAX_UNSUCCESS_LOGIN <= $this->unsuccessLoginCount)
		{
			return true;
		}
		return false;
	}
}