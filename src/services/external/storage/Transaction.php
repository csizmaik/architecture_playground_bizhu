<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 3/29/2017
 * Time: 8:56 PM
 */

namespace services\external\storage;


interface Transaction
{
	public function transactional(callable $transactionalFunction);
}