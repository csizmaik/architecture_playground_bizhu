<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 3/20/2017
 * Time: 1:53 PM
 */

namespace graphql_base\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use graphql_base\Types;

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
					'name' =>[
						'type' => Type::string()
					],
					'email' => [
						'type' => Type::string()
					],
					'status' => [
						'type' => Types::userStatus()
					]
				];
			},
			'resolveField' => function($value, $args, $context, ResolveInfo $info) {
				return $value->{$info->fieldName};
			}
		];
		parent::__construct($config);
	}

}