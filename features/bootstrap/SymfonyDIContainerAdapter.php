<?php
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

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

    public function __construct($DIContainerConfigPath, $DIContainerConfigFilename)
    {
        $this->initContainer($DIContainerConfigPath, $DIContainerConfigFilename);
    }

    public function getService($serviceName) {
        return $this->DIContainer->get($serviceName);
    }

    private function initContainer($DIContainerConfigPath, $DIContainerConfigFilename) {
        $this->DIContainer = new ContainerBuilder();
        $loader = new YamlFileLoader($this->DIContainer,new FileLocator($DIContainerConfigPath));
        $loader->load($DIContainerConfigFilename);
    }


}