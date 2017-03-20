<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 3/20/2017
 * Time: 4:14 PM
 */

namespace graphql_base\Type;


use GraphQL\Type\Definition\EnumType;
use graphql_base\Data\UserStatus;

class UserStatusType extends EnumType
{
	public function __construct()
	{
		$config = [
			'name' => 'UserStatus',
			'description' => 'User status values',
			'values' => [
				'REGISTERED' => [
					'value' => UserStatus::REGISTERED,
					'description' => 'Registered but not activated'
				],
				'ACTIVE' => [
					'value' => UserStatus::ACTIVE,
					'description' => 'Activated'
				],
				'INACTICE' => [
					'value' => UserStatus::INACTIVE,
					'description' => 'Inactivated'
				]
			]
		];
		parent::__construct($config);
	}


}