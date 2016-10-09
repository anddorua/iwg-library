<?php
/**
 * Service locator
 * used for app services instantiation
 *
 * accepts config as follows:
 * [
 *      'srv1' => [
 *          'class' => 'MyServiceClass',
 *          'params' => ['param', 'to', 'put', 'to', 'constructor'],
 *      ],
 *      ...
 * ]
 *
 * Created by PhpStorm.
 * User: andrey
 * Date: 09.10.16
 * Time: 17:28
 */

namespace Core;


class ServiceLocator
{
    private $instantiated = [];
    private $config = null;

    /**
     * ServiceLocator constructor.
     * @param null $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * Returns instance of service
     * @param $name
     * @return mixed
     * @throws ESLServiceNotDefined
     */
    function __get($name)
    {
        if (!array_key_exists($name, $this->instantiated)) {
            if (!array_key_exists($name, $this->config)) {
                throw new ESLServiceNotDefined("Service with name $name does not defined in config");
            }

            $serviceClass = $this->config[$name]['class'];
            $classInitParams = $this->config[$name]['params'];

            $reflectionClass = new \ReflectionClass($serviceClass);
            $this->instantiated[$name] = $reflectionClass->newInstanceArgs($classInitParams);
        }
        return $this->instantiated[$name];
    }


}