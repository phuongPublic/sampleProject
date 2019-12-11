<?php

namespace App\Test\TestCase;

use \Cake\TestSuite\TestCase;
use ReflectionClass;

abstract class NoptShellTestCase extends TestCase
{

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    protected function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    /**
     * Set protected/private variable of a class.
     *
     * @param object &$object      Instantiated object that we will set variable.
     * @param string $propertyName Variable name to set.
     * @param array  $value        Value to be set to variable.
     *
     * @return void
     */
    protected function invokeProperty(&$object, $propertyName, $value)
    {
        $reflection = new ReflectionClass(get_class($object));
        $property = $reflection->getProperty($propertyName);
        $property->setAccessible(true);
        $property->setValue($object, $value);
    }

}
