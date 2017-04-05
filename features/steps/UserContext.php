<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 3/24/2017
 * Time: 4:49 PM
 */
use base\DatabaseInit;
use base\SymfonyDIContainerAwareContext;
use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;

class UserContext extends SymfonyDIContainerAwareContext implements Context
{
	private $registrationResult;
	private $successLogin;
	/**
	 * @BeforeScenario
	 */
	public function initDIContainer(BeforeScenarioScope $beforeSuiteScope) {
		parent::initDIContainer($beforeSuiteScope);
	}
	/**
	 * @BeforeScenario
	 */
	public function initDatabase()
	{
		/** @var \PDO $PDO */
		$PDO = $this->getService('pdo');
		$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$PDO->exec("
			CREATE TABLE 
				users 
			  (
				id INTEGER PRIMARY KEY, 
				name VARCHAR, 
				login VARCHAR, 
				password VARCHAR,
				unsuccessLoginCount INTEGER, 
				active INTEGER,
				lastSuccessLoginDate TIME
			  )
		");
	}
	/**
	 * @Given /^a user base where "([^"]*)" loginname hasn't registered yet$/
	 */
	public function aUserBaseWhereLoginnameHasnTRegisteredYet($loginName)
	{
		/** @var \services\internal\user\UserRepository $userRepository */
		$userRepository = $this->getService('user_repository');
		if ($userRepository->isUserExistsWithLogin($loginName))
		{
			$userRepository->removeUserByLoginName($loginName);
		}
	}
	/**
	 * @Given /^a registered user with "([^"]*)" loginname and "([^"]*)" password$/
	 */
	public function aRegisteredUserWithLoginnameAndPassword($login, $password)
	{
		/** @var \services\internal\user\UserRepository $userRepository */
		$userRepository = $this->getService('user_repository');
		if (!$userRepository->isUserExistsWithLogin($login))
		{
			/** @var \services\internal\user\UserManagementService $userService */
			$userService = $this->getService('user_management_service');
			$userService->registerUser("Existing User",$login,$password);
		}
	}
	/**
	 * @Given /^"([^"]*)" user is deactivated$/
	 */
	public function userIsDeactivated($loginName)
	{
		/** @var \services\internal\user\UserManagementService $authService */
		$authService = $this->getService('user_management_service');
		$authService->deactivateUserByLogin($loginName);
	}
	/**
	 * @When /^the user "([^"]*)" tries to register with "([^"]*)" loginname and "([^"]*)" password$/
	 */
	public function theUserTriesToRegisterWithLoginnameAndPassword($name, $login, $password)
	{
		/** @var \services\internal\user\UserManagementService $userService */
		$userService = $this->getService('user_management_service');
		try {
			$this->registrationResult = $userService->registerUser($name, $login, $password);
		} catch (Exception $exception) {
			$this->registrationResult = $exception;
		}
	}
	/**
	 * @Then /^the registration is "([^"]*)"$/
	 */
	public function theRegistrationIs($expectedRegistrationResult)
	{
		switch ($expectedRegistrationResult) {
			case 'success':
				\PHPUnit\Framework\Assert::assertGreaterThan(0, $this->registrationResult);
				break;
			case 'failed':
				\PHPUnit\Framework\Assert::assertInstanceOf("Exception", $this->registrationResult);
				break;
		}
	}
	/**
	 * @When /^"([^"]*)" user tries to login with "([^"]*)" password$/
	 */
	public function userTriesToLoginWithPassword($login, $password)
	{
		/** @var \services\internal\user\AuthService $authService */
		$authService = $this->getService('auth_service');
		try {
			$authService->login($login, $password);
			$this->successLogin = true;
		} catch (InvalidArgumentException $exception) {
			$this->successLogin = false;
		}
	}
	/**
	 * @Then /^the login is "([^"]*)"$/
	 */
	public function theLoginIs($expectedResult)
	{
		switch ($expectedResult) {
			case 'success':
				\PHPUnit\Framework\Assert::assertTrue($this->successLogin);
				break;
			case 'failed':
				\PHPUnit\Framework\Assert::assertFalse($this->successLogin);
				break;
		}
	}
	/**
	 * @Given /^reset unsuccess login counter for "([^"]*)" user$/
	 */
	public function resetUnsuccessLoginCounterForUser($login)
	{
		/** @var \services\internal\user\UserRepository $userRepository */
		$userRepository = $this->getService('user_repository');

		$userData = $userRepository->getByLogin($login);
		/** @var \services\internal\user\UserManagementService $userService */
		$userService = $this->getService('user_management_service');
		$userService->resetUnsuccessLoginCounterByUserId($userData['id']);
	}
}