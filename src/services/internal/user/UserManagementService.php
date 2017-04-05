<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 3/26/2017
 * Time: 8:24 AM
 */
namespace services\internal\user;


class UserManagementService
{
	private $userRepository;

	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	public function registerUser($name, $login, $password)
	{
		LoginNameValidator::validate($login);
		$this->reservedLoginCheck($login);
		$userId = $this->userRepository->nextId();
		$this->userRepository->createNewUserWithData($userId, $name, $login, $password);
		return $userId;
	}

	public function reservedLoginCheck($login)
	{
		ReservedLoginChecker::check(
			$this->userRepository->isUserExistsWithLogin($login)
		);
	}

	public function deactivateUserByLogin($login)
	{
		$this->userRepository->deactivateUserByLogin($login);
	}

	public function deactivateUserById($userId)
	{
		$this->userRepository->deactivateUserById($userId);
	}

	public function resetUnsuccessLoginCounterByUserId($userId)
	{
		$this->userRepository->resetUnsuccessLoginCounterByUserId($userId);
	}
}