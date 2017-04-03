<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 3/26/2017
 * Time: 12:11 PM
 */

namespace services\external\storage;


use Doctrine\ORM\EntityRepository;
use services\internal\user\User;
use services\internal\user\UserRepository;

class DoctrineUserRepository extends EntityRepository implements UserRepository
{
	public function nextId()
	{
		return uniqid();
	}

	public function getUserById($userId)
	{
		$user = $this->find($userId);
		if (!is_object($user))
		{
			throw new \InvalidArgumentException("No user with id: ".$userId);
		}
		return $user;
	}

	public function isUserExistsWithLogin($login)
	{
		try {
			$this->getUserByLoginName($login);
			return true;
		} catch (\InvalidArgumentException $exception) {
			return false;
		}
	}

	public function getUserByLoginName($loginName)
	{
		$user = $this->findOneBy([
			'login' => $loginName
		]);
		if (!is_object($user))
		{
			throw new \InvalidArgumentException("No user with loginname: ".$loginName);
		}
		return $user;
	}

	public function addUser(User $user)
	{
		$this->getEntityManager()->persist($user);
	}

	public function removeUserByLoginName($loginName)
	{
		/** @var User $user */
		$user = $this->getUserByLoginName($loginName);
		$this->getEntityManager()->remove($user);
	}
}