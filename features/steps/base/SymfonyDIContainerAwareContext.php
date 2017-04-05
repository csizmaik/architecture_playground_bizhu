<?php
namespace base;

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;

/**
 * Created by PhpStorm.
 * User: Norbi
 * Date: 2017. 03. 12.
 * Time: 13:59
 */
abstract class SymfonyDIContainerAwareContext implements Context
{
	/**
	 * @var DIContainerAdapter
	 */
	protected $DIContainerAdapter;

	protected function initDIContainer(BeforeScenarioScope $beforeSuiteScope)
	{
		$suite = $beforeSuiteScope->getEnvironment()->getSuite();
		$DIContainerAdapterClass = $suite->getSetting('DIContainerAdapterClass');
		$DIContainerConfigPath = $suite->getSetting('DIContainerConfigPath');
		$this->initContainerAdapter($DIContainerAdapterClass, $DIContainerConfigPath);
	}

	private function initContainerAdapter($DIContainerAdapterClass, $DIContainerConfigPath)
	{
		$this->checkAdapterClass($DIContainerAdapterClass);
		$this->DIContainerAdapter = new $DIContainerAdapterClass($DIContainerConfigPath);
		$this->checkAdapterObject();
	}

	private function checkAdapterClass($DIContainerAdapterClass)
	{
		if ( !class_exists($DIContainerAdapterClass) )
		{
			throw new \InvalidArgumentException("Unknownk DI Container Adapter class: ".$DIContainerAdapterClass);
		}
	}

	private function checkAdapterObject()
	{
		if (!$this->DIContainerAdapter instanceof DIContainerAdapter)
		{
			throw new \InvalidArgumentException("Invalid DI Container Adapter class! The adapter must implement DIContainerAdapter interface!");
		}
	}

	protected function getService($seviceName) {
		return $this->DIContainerAdapter->getService($seviceName);
	}
}