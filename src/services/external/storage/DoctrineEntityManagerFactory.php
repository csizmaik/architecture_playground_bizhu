<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 3/26/2017
 * Time: 12:01 PM
 */

namespace services\external\storage;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class DoctrineEntityManagerFactory
{
	public function __construct()
	{
	}

	public static function getInstance()
	{
		$isDevMode = true;
		$config = Setup::createYAMLMetadataConfiguration([__DIR__."/mapping"],$isDevMode);
		//$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/../../internal"), $isDevMode);
		$conn = array(
			'url' => 'sqlite:///:memory:'
		);
		$entityManager = EntityManager::create($conn, $config);
		return $entityManager;
	}
}