<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 4/6/2017
 * Time: 6:08 PM
 */

namespace services\internal\auth;


use Exception;

class AuthenticationFailedException extends \Exception
{
	private $failReasons;

	public function __construct($message = "", $code = 0, Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}

	public function setFailReasons($failReasons)
	{
		$this->failReasons = $failReasons;
	}

	public function getFailReasons()
	{
		return $this->failReasons;
	}


}