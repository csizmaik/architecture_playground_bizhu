<?php
use Behat\Behat\Context\Context;
use Behat\Testwork\Hook\Scope\BeforeSuiteScope;

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
    private static $DIContainerAdapter;

    /**
     * @BeforeSuite
     */
    public static function initDIContainer(BeforeSuiteScope $beforeSuiteScope) {
        $suite = $beforeSuiteScope->getEnvironment()->getSuite();
        $DIContainerAdapterClass = $suite->getSetting('DIContainerAdapterClass');
        $DIContainerConfigPath = $suite->getSetting('DIContainerConfigPath');
        $DIContainerConfigFilename = $suite->getSetting('DIContainerConfigFilename');

        self::initContainerAdapter($DIContainerAdapterClass, $DIContainerConfigPath, $DIContainerConfigFilename);
    }

    private static function initContainerAdapter($DIContainerAdapterClass, $DIContainerConfigPath, $DIContainerConfigFilename) {
        self::checkAdapterClass($DIContainerAdapterClass);
        self::$DIContainerAdapter = new $DIContainerAdapterClass($DIContainerConfigPath, $DIContainerConfigFilename);
        self::checkAdapterObject();
    }

    private static function checkAdapterClass($DIContainerAdapterClass) {
        if ( !class_exists($DIContainerAdapterClass) ) {
            throw new InvalidArgumentException("Unknownk DI Container Adapter class: ".$DIContainerAdapterClass);
        }
    }

    private static function checkAdapterObject() {
        if (!self::$DIContainerAdapter instanceof DIContainerAdapter) {
            throw new InvalidArgumentException("Invalid DI Container Adapter class! The adapter must implement DIContainerAdapter interface!");
        }
    }

    protected static function getService($seviceName) {
        return self::$DIContainerAdapter->getService($seviceName);
    }

}