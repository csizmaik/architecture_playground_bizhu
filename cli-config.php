<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 3/27/2017
 * Time: 4:20 PM
 */

require_once("vendor/autoload.php");

use services\external\storage\DoctrineEntityManagerFactory;
use \Doctrine\ORM\Tools\Console\ConsoleRunner;

return ConsoleRunner::createHelperSet(
			DoctrineEntityManagerFactory::getInstance()
		);