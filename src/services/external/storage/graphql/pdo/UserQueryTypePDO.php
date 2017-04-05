<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 4/4/2017
 * Time: 3:36 PM
 */

namespace services\external\storage\graphql\pdo;

use services\external\storage\graphql\types\UserQueryType;

class UserQueryTypePDO extends UserQueryType
{
	private $PDO;

	public function __construct(\PDO $PDO)
	{
		$this->PDO = $PDO;
		parent::__construct();
	}

	public function user($rootValue, $args)
	{
		$userId = $args['id'];
		$statement = $this->PDO->prepare("SELECT * FROM users WHERE id=:userId");
		$statement->bindValue(":userId",$userId);
		$statement->execute();
		return $statement->fetch();
	}

	public function userByLogin($rootValue, $args)
	{
		$loginName = $args['loginName'];
		$statement = $this->PDO->prepare("SELECT * FROM users WHERE login=:login");
		$statement->bindValue(":login",$loginName);
		$statement->execute();
		return $statement->fetch();
	}

	public function allUsers($rootValue, $args)
	{
		$limit = isset($args['limit']) ? intval($args['limit']) : 0;
		$statement = $this->PDO->prepare("SELECT * FROM users LIMIT :limit");
		$statement->bindValue(":limit", $limit);
		$statement->execute();
		return $statement->fetchAll();
	}
}