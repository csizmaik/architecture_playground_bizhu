<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 4/3/2017
 * Time: 5:00 PM
 */

use services\external\storage\graphql\GraphQLUserRepository;
use services\external\storage\graphql\pdo\UserMutationTypePDO;
use services\external\storage\graphql\pdo\UserQueryTypePDO;
use services\internal\user\AuthService;
use services\internal\user\UserManagementService;

require_once "vendor/autoload.php";

$PDO = new PDO('sqlite::memory:');
$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$PDO->exec("
	CREATE TABLE 
		users 
	  (
	  	id INTEGER PRIMARY KEY, 
	  	name VARCHAR, 
	  	login VARCHAR, 
	  	password VARCHAR,
	  	unsuccessLoginCount INTEGER, 
	  	active INTEGER,
	  	lastSuccessLoginDate TIME
	  )
");
$PDO->exec("INSERT INTO users VALUES (1,'John Doo','norbi','secret', 0, 1,NULL )");

$queryType = new UserQueryTypePDO($PDO);
$mutationType = new UserMutationTypePDO($PDO);

$userRepo = new GraphQLUserRepository($queryType,$mutationType);

$userManagementService = new UserManagementService($userRepo);
$userManagementService->registerUser("Csizmarik Norbert","norbi2","secret");

$authService = new AuthService($userRepo);
try{
	$authService->login("norbi2","secret_x");
} catch (Exception $e)
{

}


$query = $PDO->query("SELECT * FROM users");
$query->execute();
print_r($query->fetchAll());

/*
$userManagementService = new UserManagementService($userRepo);
$userManagementService->reservedLoginCheck("norbi2");
*/