<?php
namespace services\external\storage\graphql\types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 4/3/2017
 * Time: 5:23 PM
 */
class UserType extends ObjectType
{
	public function __construct()
	{
		$config = [
			'name' => 'PortalUser',
			'description' => 'Portal user',
			'fields' => function() {
				return [
					'id' => [
						'type' => Type::id()
					],
					'name' => [
						'type' => Type::string()
					],
					'login' =>[
						'type' => Type::string()
					],
					'password' => [
						'type' => Type::string()
					],
					'active' => [
						'type' => Type::int()
					],
					'unsuccessLoginCount' => [
						'type' => Type::int()
					],
					'lastSuccessLogin' => [
						'type' => Type::string()
					]
				];
			},
			'resolveField' => function($value, $args, $context, ResolveInfo $info) {
				return $value[$info->fieldName];
			}
		];
		parent::__construct($config);
	}

}