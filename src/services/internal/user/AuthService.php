<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 3/24/2017
 * Time: 4:51 PM
 */

namespace services\internal\user;

use services\external\storage\Transaction;
use services\external\time\TimeService;


class AuthService
{
	/**
	 * @var UserRepository
	 */
	private $userRepository;
	/**
	 * @var Transaction
	 */
	private $transactionService;
	/**
	 * @var TimeService
	 */
	private $timeService;

	public function __construct(UserRepository $userRepository, Transaction $transactionService, TimeService $timeService)
	{
		$this->userRepository = $userRepository;
		$this->transactionService = $transactionService;
		$this->timeService = $timeService;
	}

	public function login($login, $password)
	{
		/** @var User $userToLogin */
		$userToLogin = $this->userRepository->getUserByLoginName($login);
		$userToLogin->loginWithPasswordAt(
			$password,
			$this->timeService->getCurrentDateTime()
		);
		$this->transactionService->flush();
	}
}