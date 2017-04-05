<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 4/3/2017
 * Time: 2:18 PM
 */

namespace services\external\storage\graphql\types;

use GraphQL\Type\Definition\NonNull;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

abstract class UserQueryType extends ObjectType
{
	public function __construct()
	{
		$config = [
			'fields' => [
				'user' => [
					'type' => TypeRegistry::user(),
					'description' => 'Returns user by id',
					'args' => [
						'id' => new NonNull(Type::id())
					]
				],
				'userByLogin' => [
					'type' => TypeRegistry::user(),
					'description' => 'Returns user by login name',
					'args' => [
						'loginName' => new NonNull(Type::string())
					]
				],
				'allUsers' => [
					'type' => Type::listOf(TypeRegistry::user()),
					'description' => 'Returns all user',
					'args' => [
						'limit'	=> Type::int()
					]
				]
			],
			'resolveField' => function($val, $args, $context, ResolveInfo $info) {
				return $this->{$info->fieldName}($val, $args, $context, $info);
			}
		];
		parent::__construct($config);
	}

	abstract public function user($rootValue, $args);
	abstract public function userByLogin($rootValue, $args);
	abstract public function allUsers($rootValue, $args);
}