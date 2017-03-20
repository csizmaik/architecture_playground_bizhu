<?php

namespace graphql_base;

use GraphQL\Type\Definition\NonNull;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use graphql_base\Data\DataSource;

/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 3/20/2017
 * Time: 1:13 PM
 */
class QueryType extends ObjectType
{
	public function __construct()
	{
		$config = [
			'name' => 'UserQuery',
			'fields' => [
				'hello' => Type::string(),
				'user' => [
					'type' => Types::user(),
					'description' => 'Returns user by id',
					'args' => [
						'id' => new NonNull(Type::id())
					]
				],
				'lastUser' => [
					'type' => Types::user(),
					'description' => 'Last registered user'
				],
				'allUsers' => [
					'type' => Type::listOf(Types::user()),
					'description' => 'Returns all user',
					'args' => [
						'limit'	=> Type::int()
					]
				],
				'activeUsers' => [
					'type' => Type::listOf(Types::user()),
					'description' => 'All active user'
				]
			],
			'resolveField' => function($val, $args, $context, ResolveInfo $info) {
				return $this->{$info->fieldName}($val, $args, $context, $info);
			}
		];
		parent::__construct($config);
	}

	public function user($rootValue, $args)
	{
		return DataSource::findUser($args['id']);
	}

	public function lastUser() {
		return DataSource::findLastUser();
	}

	public function allUsers($rootValue, $args)
	{
		$limit = isset($args['limit']) ? intval($args['limit']) : 0;
		return DataSource::findAllUsers($limit);
	}

	public function activeUsers() {
		return DataSource::activeUsers();
	}

	public function hello()
	{
		return 'Your graphql_base-php endpoint is ready! Use GraphiQL to browse API';
	}
}