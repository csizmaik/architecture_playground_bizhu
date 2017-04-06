<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 3/29/2017
 * Time: 8:57 PM
 */

namespace services\external\storage;

use Doctrine\ORM\EntityManager;

class DoctrineTransaction implements Transaction
{
	/**
	 * @var EntityManager
	 */
	private $entityManager;

	/**
	 * DoctrineTransaction constructor.
	 */
	public function __construct(EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function transactional(callable $transactionalFunction)
	{
		return $this->entityManager->transactional($transactionalFunction);
	}

	public function flush()
	{
		$this->entityManager->flush();
	}
}