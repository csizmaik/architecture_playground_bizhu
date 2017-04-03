<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 3/24/2017
 * Time: 5:13 PM
 */

namespace services\internal\user;


interface UserRepository
{
	public function nextId();
	public function getUserById($userId);
	public function isUserExistsWithLogin($login);
	public function getUserByLoginName($login);
	public function addUser(User $user);
	public function removeUserByLoginName($loginName);
}