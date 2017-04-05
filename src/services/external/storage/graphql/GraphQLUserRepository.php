<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 4/3/2017
 * Time: 2:00 PM
 */

namespace services\external\storage\graphql;

use GraphQL\GraphQL;
use GraphQL\Schema;
use services\external\storage\graphql\types\TypeRegistry;
use services\external\storage\graphql\types\UserMutationType;
use services\external\storage\graphql\types\UserQueryType;
use services\internal\user\UserRepository;

class GraphQLUserRepository implements UserRepository
{
	private $userSchema;

	public function __construct(UserQueryType $queryType, UserMutationType $mutationType)
	{
		$this->userSchema = new Schema([
			'query' => $queryType,
			'mutation' => $mutationType,
			'types' => [
				TypeRegistry::user()
			]
		]);
	}

	public function nextId()
	{
		return uniqid();
	}

	public function getByLogin($login)
	{
		$result = $this->executeRequest(
			'query UserQueryType { 
				userByLogin(loginName: "'.$login.'") { 
					id,
					name,
					login,
					password,
					active,
					unsuccessLoginCount
				} 
			}'
		);
		return (isset($result['userByLogin']['id']) ? $result['userByLogin'] : null);
	}

	public function isUserExistsWithLogin($login)
	{
		$result = $this->getByLogin($login);
		return intval($result['userByLogin']['id']) > 0;
	}

	public function createNewUserWithData($userId, $name, $login, $password)
	{
		$this->executeRequest(
			'mutation UserMutationType { 
				createNew(
					login: "'.$login.'", 
					password: "'.$password.'", 
					name: "'.$name.'",
					unsuccessLoginCount: 0, 
					active: 1
				)
			}'
		);
	}

	public function deactivateUserByLogin($login)
	{
		$this->executeRequest(
			'mutation UserMutationType { 
				deactivateUserByLogin(login: "'.$login.'")
			}'
		);
	}

	public function deactivateUserById($userId)
	{
		$this->executeRequest(
			'mutation UserMutationType { 
				deactivateUserById(id: "'.$userId.'")
			}'
		);
	}

	public function resetUnsuccessLoginCounterByUserId($userId)
	{
		$this->executeRequest(
			'mutation UserMutationType { 
				resetUnsuccessLoginCounterByUserId(id: '.$userId.')
			}'
		);
	}



	public function updateLastSuccessLogin($userId, \DateTime $lastSuccessLoginDate)
	{
		$this->executeRequest(
			'mutation UserMutationType { 
				updateLastSuccessLogin(id: '.$userId.', lastSuccessLoginDate: "'.$lastSuccessLoginDate->format("Y-m-d H:i:s").'")
			}'
		);
	}

	public function removeUserByLoginName($login)
	{
		$this->executeRequest(
			'mutation UserMutationType { 
				removeUserByLoginName(login: "'.$login.'")
			}'
		);
	}

	public function increaseUnsuccessLoginCounterForLogin($login)
	{
		$this->executeRequest(
			'mutation UserMutationType { 
				increaseUnsuccessLoginCounterForLogin(login: "'.$login.'")
			}'
		);
	}

	private function executeRequest($requestString)
	{
		$result = GraphQL::execute(
			$this->userSchema,
			$requestString
		);
		return isset($result['data']) ? $result['data'] : $result;
	}
}