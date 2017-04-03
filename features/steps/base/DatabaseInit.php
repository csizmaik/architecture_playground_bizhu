<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 3/28/2017
 * Time: 5:52 PM
 */

namespace base;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;

class DatabaseInit
{
	public static function initDatabaseSchema(EntityManager $entityManager)
	{
		$schemaTool = new SchemaTool($entityManager);
		$classes = $entityManager->getMetadataFactory()->getAllMetadata();
		$schemaTool->dropSchema($classes);
		$schemaTool->createSchema($classes);
	}
}