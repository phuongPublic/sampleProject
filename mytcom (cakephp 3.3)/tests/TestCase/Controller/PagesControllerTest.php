<?php

namespace App\Test\TestCase\Controller;

use App\Controller\PagesController;
use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\Network\Exception\NotFoundException;
use Cake\Core\Configure;
use ReflectionMethod;

/**
 * App\Controller\AddressListviewController Test Case
 */
class PagesControllerTest extends NoptIntegrationTestCase
{
     /**
     * Test display method
     * @codeCoverageIgnore
     * test テスト資源対象外に修正。sample code
     *
     * @return void
     */
    public function display()
    {
        $reflectionMethod = new ReflectionMethod ( 'App\Controller\PagesController', 'display' );
        // case 1
        $result = true;
        try {
            $reflectionMethod->invoke ( new PagesController (), 'home');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        // case 2
        $result = true;
        try {
            $reflectionMethod->invoke ( new PagesController ());
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        // case 3
        $result = true;
        try {
            $reflectionMethod->invoke ( new PagesController (), '1', 'home');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertFalse($result);

        // case 4
        Configure::write('debug', 0);
        $result = true;
        try {
            $reflectionMethod->invoke ( new PagesController (), '1');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertFalse($result);

        // case 4
        Configure::write('debug', 1);
        $result = true;
        try {
            $reflectionMethod->invoke ( new PagesController (), '1');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertFalse($result);
    }

    /**
     * 対象のデータを固定でセッションに格納
     *
     * @return void
     */
    protected function setSession()
    {
    }
}