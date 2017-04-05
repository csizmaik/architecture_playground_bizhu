<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 4/4/2017
 * Time: 11:15 AM
 */

namespace services\internal\user;

use services\internal\time\TimeService;

class AuthService
{
	/**
	 * @var UserRepository
	 */
	private $userRepository;
	/**
	 * @var TimeService
	 */
	private $timeService;

	public function __construct(UserRepository $userRepository, TimeService $timeService)
	{
		$this->userRepository = $userRepository;
		$this->timeService = $timeService;
	}

	public function login($login, $password)
	{
		$userData = $this->userRepository->getByLogin($login);
		$auth = Authentication::createForUserData($login, $userData['password'], $userData['unsuccessLoginCount'], $userData['active']);
		try
		{
			$auth->checkLoginWithPassword($password);
		}
		catch (\InvalidArgumentException $loginException)
		{
			// TODO - hogy kellene a sikertelen authentikációt visszaírni a userhez ha nem használhatok controll structure-t?
			$this->userRepository->increaseUnsuccessLoginCounterForLogin($login);
			throw $loginException;
		}
		$this->userRepository->updateLastSuccessLogin($userData['id'], $this->timeService->getCurrentDateTime());
	}
}