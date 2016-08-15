<?php

/**
 * This file is part of Thallium.
 *
 * Thallium, a PHP-based framework for web applications.
 * Copyright (C) <2015-2016> <Andreas Unterkircher>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 */

/**
 * This file is used to test Thalliums DefaultController.
 *
 * @license AGPL3
 * @copyright 2015-2016 Andreas Unterkircher <unki@netshadow.net>
 * @author Andreas Unterkircher <unki@netshadow.net>
 */
namespace Thallium\Tests;

use PHPUnit\Framework\TestCase;

class DefaultControllerTest extends TestCase
{
    /**
     * instances the DefaultController.
     * All other tests are depending on this method.
     *
     * @params none
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     */
    public function testConstruct()
    {
        $thallium = new \Thallium\Controllers\MainController('install');

        $controller = $this->getMockForAbstractClass('\Thallium\Controllers\DefaultController');
        $this->assertInstanceOf('\Thallium\Controllers\DefaultController', $controller);

        return $controller;
    }

    /**
     * verify the CONFIG_DIRECTORY class constant.
     *
     * @params none
     * @returns void
     * @throws none
     */
    public function testConstantConfigDirectory()
    {
        $this->assertStringMatchesFormat('%s', \Thallium\Controllers\DefaultController::CONFIG_DIRECTORY);
        $this->assertTrue(file_exists(\Thallium\Controllers\DefaultController::CONFIG_DIRECTORY));
    }

    /**
     * verify the CACHE_DIRECTORY class constant.
     *
     * @params none
     * @returns void
     * @throws none
     */
    public function testConstantCacheDirectory()
    {
        $this->assertStringMatchesFormat('%s', \Thallium\Controllers\DefaultController::CACHE_DIRECTORY);
        $this->assertTrue(file_exists(\Thallium\Controllers\DefaultController::CACHE_DIRECTORY));
    }

    /**
     * verify the LOG_LEVEL class constant.
     *
     * @params object $controller
     * @returns void
     * @throws none
     */
    public function testConstantLogLevel()
    {
        $this->assertTrue(is_int(\Thallium\Controllers\DefaultController::LOG_LEVEL));
    }

    /**
     * a test of the __set() method that is called on setting previously
     * not-initially declared class properties.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @expectedException \Thallium\Controllers\ExceptionController
     */
    public function testSet(\Thallium\Controllers\DefaultController $controller)
    {
        $controller->test_property = true;
    }

    /**
     * a test for the sendMessage() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @expectedException \Thallium\Controllers\ExceptionController
     */
    public function testSendMessage(\Thallium\Controllers\DefaultController $controller)
    {
        $this->assertTrue($controller->sendMessage('TestCommand', 'TestBody'));
    }

    /**
     * a test for the raiseError() method.
     *
     * @params none
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @expectedException \Thallium\Controllers\ExceptionController
     */
    public function testRaiseError()
    {
        $this->expectException(\Thallium\Controllers\DefaultController::raiseError('test'));
    }

    /**
     * a test for the write() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testWrite(\Thallium\Controllers\DefaultController $controller)
    {
        $this->assertTrue($controller->write(
            'test_text'
        ));
    }

    /**
     * a test for the isCmdline() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testIsCmdline(\Thallium\Controllers\DefaultController $controller)
    {
        $this->assertTrue($controller->isCmdline());
    }

    /**
     * a test for the getVerbosity() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testGetVerbosity(\Thallium\Controllers\DefaultController $controller)
    {
        $this->assertTrue(is_int($controller->getVerbosity()));
    }

    /**
     * a test for the requireModel() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testrequireModel(\Thallium\Controllers\DefaultController $controller)
    {
        $test_obj = new \stdClass;
        $this->assertFalse($controller->requireModel($test_obj, 'MessageModel'));
        unset($test_obj);

        $test_obj = new \Thallium\Models\MessageModel;
        $this->assertTrue($controller->requireModel($test_obj, 'MessageModel'));
        unset($test_obj);
    }
}

// vim: set filetype=php expandtab softtabstop=4 tabstop=4 shiftwidth=4:
