<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 4/4/2017
 * Time: 3:36 PM
 */

namespace services\external\storage\graphql\pdo;

use services\external\storage\graphql\types\UserMutationType;

class UserMutationTypePDO extends UserMutationType
{
	private $PDO;

	public function __construct(\PDO $PDO)
	{
		$this->PDO = $PDO;
		parent::__construct();
	}

	protected function createNew($name, $login, $password, $unsuccessLoginCount, $active)
	{
		$statement = $this->PDO->prepare("INSERT INTO users (id,`name`,login,password,unsuccessLoginCount,active) VALUES ( NULL, :fullName, :login, :password, :unsuccessLoginCount,:active)");
		$statement->bindValue(":fullName",$name);
		$statement->bindValue(":login",$login);
		$statement->bindValue(":password",$password);
		$statement->bindValue(":unsuccessLoginCount",$unsuccessLoginCount);
		$statement->bindValue(":active",$active);
		$statement->execute();
	}

	protected function deactivateUserByLogin($login)
	{
		$statement = $this->PDO->prepare("UPDATE users SET active=0 WHERE login=:loginName");
		$statement->bindValue(":loginName",$login);
		$statement->execute();
	}

	protected function deactivateUserById($id)
	{
		$statement = $this->PDO->prepare("UPDATE users SET active=0 WHERE id=:id");
		$statement->bindValue(":id",$id);
		$statement->execute();
	}

	protected function resetUnsuccessLoginCounterByUserId($id)
	{
		$statement = $this->PDO->prepare("UPDATE users SET unsuccessLoginCount=0 WHERE id=:id");
		$statement->bindValue(":id",$id);
		$statement->execute();
	}

	protected function updateLastSuccessLogin($id, $lastSuccessLoginDate)
	{
		$statement = $this->PDO->prepare("UPDATE users SET lastSuccessLoginDate=:lastSuccessLoginDate WHERE id=:id");
		$statement->bindValue(":id",$id);
		$statement->bindValue(":lastSuccessLoginDate",$lastSuccessLoginDate);
		$statement->execute();
	}

	protected function removeUserByLoginName($login)
	{
		$statement = $this->PDO->prepare("DELETE FROM users WHERE login=:loginName");
		$statement->bindValue(":loginName",$login);
		$statement->execute();
	}

	protected function increaseUnsuccessLoginCounterForLogin($login)
	{
		$statement = $this->PDO->prepare("UPDATE users SET unsuccessLoginCount = unsuccessLoginCount + 1 WHERE login=:loginName");
		$statement->bindValue(":loginName",$login);
		$statement->execute();
	}
}