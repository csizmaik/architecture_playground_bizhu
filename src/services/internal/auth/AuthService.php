<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 3/24/2017
 * Time: 4:51 PM
 */

namespace services\internal\auth;

use services\external\storage\Transaction;
use services\internal\user\UserService;


class AuthService
{
	/**
	 * @var UserService
	 */
	private $userService;
	/**
	 * @var Transaction
	 */
	private $transactionService;

	public function __construct(UserService $userService, Transaction $transactionService)
	{
		$this->userService = $userService;
		$this->transactionService = $transactionService;
	}

	public function login($login, $password)
	{
		$credentialValidationResult = $this->userService->validateCredential($login, $password);
		return CredentialValidationResultProcessor::process($credentialValidationResult);
	}
}