<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 4/6/2017
 * Time: 6:06 PM
 */

namespace services\internal\auth;


use lib\validation\ValidationResult;

class CredentialValidationResultProcessor
{
	public static function process(ValidationResult $result)
	{
		if (!$result->isSuccess())
		{
			$exception = new AuthenticationFailedException("Autentication failed, bad credential!");
			$exception->setFailReasons($result->getFailureReasons());
			throw $exception;
		}
		return true;
	}
}