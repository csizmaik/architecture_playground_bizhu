<?php
namespace base;

use dic_container\DIContainerFactory;
use dic_container\Environment;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Created by PhpStorm.
 * User: Norbi
 * Date: 2017. 03. 13.
 * Time: 6:03
 */
class SymfonyDIContainerAdapter implements DIContainerAdapter
{
    /**
     * @var ContainerBuilder
     */
    private $DIContainer;

    public function __construct($DIContainerConfigPath)
    {
        $this->initContainer($DIContainerConfigPath);
    }

    public function getService($serviceName) {
        return $this->DIContainer->get($serviceName);
    }

    private function initContainer($DIContainerConfigPath) {
        $DIContainerFactory = new DIContainerFactory($DIContainerConfigPath);
        $this->DIContainer = $DIContainerFactory->createForEnvironment(Environment::TEST);
    }


	public function resetService($serviceName)
	{
		$this->DIContainer->set($serviceName, null);
	}
}