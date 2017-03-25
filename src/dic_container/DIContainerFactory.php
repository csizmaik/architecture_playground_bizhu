<?php

namespace dic_container;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Created by PhpStorm.
 * User: Norbi
 * Date: 2017. 03. 17.
 * Time: 5:42
 */
class DIContainerFactory
{
    private $DIContainerConfigPath;
    private $serviceDefFileName;
    private $configFileExtension;

    public function __construct($DIContainerConfigPath, $configFileName = 'dic_services', $configFileExtension = 'yml')
    {
        $this->DIContainerConfigPath = $DIContainerConfigPath;
        $this->serviceDefFileName = $configFileName;
        $this->configFileExtension = $configFileExtension;
    }

    /**
     * @param string $environment
     * @return ContainerBuilder
     */
    public function createForEnvironment($environment = 'prod') {
        $DIContainer = new ContainerBuilder();
        $loader = new YamlFileLoader($DIContainer,new FileLocator($this->DIContainerConfigPath));
        $loader->load($this->getBaseConfigFileName());
        $envConfigFile = $this->getEnvConfigFileName($environment);
        $envConfigPath = $this->DIContainerConfigPath . DIRECTORY_SEPARATOR . $envConfigFile;
        if (file_exists($envConfigPath))
        {
            $loader->load($envConfigFile);
        }
		$loader->load($this->getServicesFileName());
        return $DIContainer;
    }

    private function getBaseConfigFileName() {
        return $this->serviceDefFileName . "_config." . $this->configFileExtension;
    }

    private function getEnvConfigFileName($environment) {
        return $this->serviceDefFileName . "_config_" . $environment . "." . $this->configFileExtension;
    }

    private function getServicesFileName() {
		return $this->serviceDefFileName . "." . $this->configFileExtension;
	}
}