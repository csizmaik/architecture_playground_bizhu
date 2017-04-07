<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 4/6/2017
 * Time: 5:25 PM
 */

namespace lib\validation;


class ValidationResult
{
	private $successValidation;
	private $failReasons;

	public function __construct()
	{
		$this->successValidation = true;
		$this->failReasons = array();
	}

	public function isSuccess()
	{
		return $this->successValidation;
	}

	public function addFailure($failMessage)
	{
		$this->successValidation = false;
		$this->failReasons[] = $failMessage;
	}

	public function getFailureReasons()
	{
		return $this->failReasons;
	}
}