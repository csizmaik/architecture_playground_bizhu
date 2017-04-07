<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 3/26/2017
 * Time: 8:24 AM
 */

namespace services\internal\user;

use services\external\storage\Transaction;
use services\external\time\TimeService;

class UserService
{
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

	public function registerUser($name, $login, $password)
	{
		return $this->transactionService->transactional(function() use ($name, $login, $password){
			ReservedLoginChecker::check($this->userRepository->isUserExistsWithLogin($login));
			$userId = $this->userRepository->nextId();
			$user = User::createWithData($userId, $name, $login, $password);
			$this->userRepository->addUser($user);
			return $userId;
		});
	}

	public function validateCredential($login, $password)
	{
		/** @var User $user */
		$user = $this->userRepository->getUserByLoginName($login);
		$validationResult = $user->validateCredential($password);
		$user->registerCredentialValidationResult($validationResult->isSuccess(),$this->timeService->getCurrentDateTime());
		$this->transactionService->flush();
		return $validationResult;
	}

	public function deactivateUserByLogin($login)
	{
		$this->transactionService->transactional(function() use($login){
			/** @var User $user */
			$user = $this->userRepository->getUserByLoginName($login);
			$user->deactivate();
		});

	}

	public function deactivateUserById($userId)
	{
		$this->transactionService->transactional(function() use($userId) {
			/** @var User $user */
			$user = $this->userRepository->getUserById($userId);
			$user->deactivate();
		});
	}

	public function resetUnsuccessLoginCounterByUserId($userId)
	{
		$this->transactionService->transactional(function() use($userId){
			/** @var User $user */
			$user = $this->userRepository->getUserById($userId);
			$user->resetUnsuccessLoginCounter();
		});
	}
}