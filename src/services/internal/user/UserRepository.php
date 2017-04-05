<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 4/3/2017
 * Time: 1:52 PM
 */

namespace services\internal\user;


interface UserRepository
{
	public function nextId();
	public function isUserExistsWithLogin($login);
	public function createNewUserWithData($userId, $name, $login, $password);
	public function deactivateUserByLogin($login);
	public function deactivateUserById($userId);
	public function resetUnsuccessLoginCounterByUserId($userId);
	public function getByLogin($login);
	public function updateLastSuccessLogin($userId, \DateTime $lastSuccessLoginDate);
	public function removeUserByLoginName($login);
	public function increaseUnsuccessLoginCounterForLogin($login);
}