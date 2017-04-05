<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 4/4/2017
 * Time: 1:43 PM
 */

namespace services\external\storage\graphql\types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

abstract class UserMutationType extends ObjectType
{
	/**
	 * UserMutationType constructor.
	 */
	public function __construct()
	{
		$config = [
			'fields' => [
				'createNew' => [
					'type' => Type::boolean(),
					'description' => 'Returns result of creation',
					'args' => [
						'name' => Type::string(),
						'login' => Type::string(),
						'password' => Type::string(),
						'unsuccessLoginCount' => Type::int(),
						'active' => Type::int()
					],
					'resolve' => function($val, $args) {
						$this->createNew($args['name'], $args['login'], $args['password'], $args['unsuccessLoginCount'], $args['active']);
					}
				],
				'deactivateUserByLogin' => [
					'type' => Type::boolean(),
					'description' => 'Deactivates the user by login name',
					'args' => [
						'login' => Type::string()
					],
					'resolve' => function($val, $args) {
						$this->deactivateUserByLogin($args['login']);
					}
				],
				'deactivateUserById' => [
					'type' => Type::boolean(),
					'description' => 'Deactivates the user by id',
					'args' => [
						'id' => Type::int()
					],
					'resolve' => function($val, $args) {
						$this->deactivateUserById($args['id']);
					}
				],
				'resetUnsuccessLoginCounterByUserId' => [
					'type' => Type::boolean(),
					'description' => 'Resets unsuccess login counter the user by id',
					'args' => [
						'id' => Type::int()
					],
					'resolve' => function($val, $args) {
						$this->resetUnsuccessLoginCounterByUserId($args['id']);
					}
				],
				'updateLastSuccessLogin' => [
					'type' => Type::boolean(),
					'description' => 'Updates last sucess login',
					'args' => [
						'id' => Type::int(),
						'lastSuccessLoginDate' => Type::string()
					],
					'resolve' => function($val, $args) {
						$this->updateLastSuccessLogin($args['id'],$args['lastSuccessLoginDate']);
					}
				],
				'removeUserByLoginName' => [
					'type' => Type::boolean(),
					'description' => 'Removes user by login name',
					'args' => [
						'login' => Type::string()
					],
					'resolve' => function($val, $args) {
						$this->removeUserByLoginName($args['login']);
					}
				],
				'increaseUnsuccessLoginCounterForLogin' => [
					'type' => Type::boolean(),
					'description' => 'Increase unsuccess login counter by login name',
					'args' => [
						'login' => Type::string()
					],
					'resolve' => function($val, $args) {
						$this->increaseUnsuccessLoginCounterForLogin($args['login']);
					}
				],
			]
		];
		parent::__construct($config);
	}

	abstract protected function createNew($name, $login, $password, $unsuccessLoginCount, $active);
	abstract protected function deactivateUserByLogin($login);
	abstract protected function deactivateUserById($id);
	abstract protected function resetUnsuccessLoginCounterByUserId($id);
	abstract protected function updateLastSuccessLogin($id, $lastSuccessLoginDate);
	abstract protected function removeUserByLoginName($login);
	abstract protected function increaseUnsuccessLoginCounterForLogin($login);
}