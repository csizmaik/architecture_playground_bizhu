<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 4/7/2017
 * Time: 10:09 AM
 */

namespace services\internal\auth;

use lib\validation\ValidationResult;
use PHPUnit\Framework\TestCase;

class CredentialValidationResultProcessorTest extends TestCase
{
	public function testValidResult()
	{
		$validationResult = new ValidationResult();
		$result = CredentialValidationResultProcessor::process($validationResult);
		$this->assertTrue($result);
	}

	public function testFailedResult()
	{
		$validationResult = new ValidationResult();
		$validationResult->addFailure("Some failure message");
		$this->expectException(AuthenticationFailedException::class);
		CredentialValidationResultProcessor::process($validationResult);
	}
}
