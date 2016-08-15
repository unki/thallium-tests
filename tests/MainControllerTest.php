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
 * This file is used to test Thalliums MainController.
 *
 * @license AGPL3
 * @copyright 2015-2016 Andreas Unterkircher <unki@netshadow.net>
 * @author Andreas Unterkircher <unki@netshadow.net>
 */
namespace Thallium\Tests;

use PHPUnit\Framework\TestCase;

class MainControllerTest extends TestCase
{
    /**
     * tries instance the MainController.
     *
     * @params none
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @expectedException \Thallium\Controllers\ExceptionController
     */
    public function testNaked()
    {
        $controller = new \Thallium\Controllers\MainController;
        $this->assertInstanceOf('\Thallium\Controllers\MainController', $controller);
    }

    /**
     * instances the MainController in install mode (= install database schema).
     * All other tests are depending on this method.
     *
     * @params none
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testNaked
     */
    public function testInit()
    {
        $controller = new \Thallium\Controllers\MainController('install');
        $this->assertInstanceOf('\Thallium\Controllers\MainController', $controller);
        return $controller;
    }

    /**
     * a test of the inTestMode() method that should return true as we are
     * calling it from phpunit.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testInit
     */
    public function testInTestMode(\Thallium\Controllers\MainController $controller)
    {
        $this->assertTrue($controller->inTestMode());
    }

    /**
     * a test of the startup() method that should return true on a successful run.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testInit
     */
    public function testStartup(\Thallium\Controllers\MainController $controller)
    {
        $this->assertTrue($controller->startup());
    }

    /**
     * a test for the runBackgroundJobs() method, which normally should return true
     * in this empty instance.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testInit
     */
    public function testRunBackgroundJobs(\Thallium\Controllers\MainController $controller)
    {
        $this->assertTrue($controller->runBackgroundJobs());
    }

    /**
     * a test for the setVerbosity() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testInit
     * @expectedException \Thallium\Controllers\ExceptionController
     */
    public function testSetVerbosity(\Thallium\Controllers\MainController $controller)
    {
        $this->expectException($controller->setVerbosity('loud'));
        $this->assertTrue($controller->setVerbosity(LOG_DEBUG));
    }

    /**
     * a test for the isValidId() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testInit
     */
    public function testIsValidId(\Thallium\Controllers\MainController $controller)
    {
        $this->assertFalse($controller->isValidId(''));
        $this->assertFalse($controller->isValidId('test'));
        $this->assertTrue($controller->isValidId('1'));
        $this->assertTrue($controller->isValidId(2));
    }

    /**
     * a test for the isValidModel() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testInit
     * @expectedException \Thallium\Controllers\ExceptionController
     */
    public function testIsValidModel(\Thallium\Controllers\MainController $controller)
    {
        $this->expectException($controller->isValidModel(''));
        $this->assertFalse($controller->isValidModel('1'));
        $this->assertFalse($controller->isValidModel(1));
        $this->assertTrue($controller->isValidModel('MessageBusModel'));
    }

    /**
     * a test for the isValidGuidSyntax() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testInit
     */
    public function testIsValidGuidSyntax(\Thallium\Controllers\MainController $controller)
    {
        $this->assertFalse($controller->isValidGuidSyntax(''));
        $this->assertFalse($controller->isValidGuidSyntax('1'));
        $this->assertFalse($controller->isValidGuidSyntax(1));

        $this->assertTrue($controller->isValidGuidSyntax(
            '0123456789012345678901234567890123456789012345678901234567890123'
        ));
    }

    /**
     * a test for the parseId() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testInit
     * @expectedException \Thallium\Controllers\ExceptionController
     */
    public function testParseId(\Thallium\Controllers\MainController $controller)
    {
        $this->expectException($controller->parseId(''));
        $this->assertFalse($controller->parseId('1'));
        $this->assertFalse($controller->parseId(1));
        $this->assertFalse($controller->parseId('message'));
        $this->assertFalse($controller->parseId('message-1'));
        $this->assertFalse($controller->parseId('message-1-2'));

        $this->assertTrue($controller->parseId(
            'message-1-0123456789012345678901234567890123456789012345678901234567890123'
        ));
    }

    /**
     * a test for the createGuid() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testInit
     */
    public function testCreateGuid(\Thallium\Controllers\MainController $controller)
    {
        $this->assertStringMatchesFormat('%s', $controller->createGuid());
        $this->assertEquals(64, strlen($controller->createGuid()));
    }

    /**
     * a test for the loadModel() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testInit
     * @expectedException \Thallium\Controllers\ExceptionController
     */
    public function testLoadModel(\Thallium\Controllers\MainController $controller)
    {
        $this->expectException($controller->loadModel('MessageModel', 1, null));
        $this->expectException($controller->loadModel('MessageModel', '1x', null));
        $this->expectException($controller->loadModel('MessageModel', 1, 1));
        $this->expectException($controller->loadModel(
            'MessageModel',
            1,
            '0123456789012345678901234567890123456789012345678901234567890123'
        ));
    }

    /**
     * a test for the checkUpgrade() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testInit
     */
    public function testCheckUpgrade(\Thallium\Controllers\MainController $controller)
    {
        $this->assertFalse($controller->checkUpgrade());
    }

    /**
     * a test for the loadController() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testInit
     */
    public function testLoadController(\Thallium\Controllers\MainController $controller)
    {
        $this->assertTrue($controller->loadController('MessageBusController', 'mbus'));
    }

    /**
     * a test for the getProcessUserId() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testInit
     */
    public function testGetProcessUserId(\Thallium\Controllers\MainController $controller)
    {
        $this->assertThat(
            $controller->getProcessUserId(),
            $this->greaterThanOrEqual(1)
        );
    }

    /**
     * a test for the getProcessGroupId() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testInit
     */
    public function testGetProcessGroupId(\Thallium\Controllers\MainController $controller)
    {
        $this->assertThat(
            $controller->getProcessGroupId(),
            $this->greaterThanOrEqual(1)
        );
    }

    /**
     * a test for the getProcessUserName() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testInit
     */
    public function testGetProcessUserName(\Thallium\Controllers\MainController $controller)
    {
        $this->assertStringMatchesFormat('%s', $controller->getProcessUserName());
    }

    /**
     * a test for the getProcessGroupName() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testInit
     */
    public function testGetProcessGroupName(\Thallium\Controllers\MainController $controller)
    {
        $this->assertStringMatchesFormat('%s', $controller->getProcessGroupName());
    }

    /**
     * a test for the processRequestMessages() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testInit
     */
    public function testProcessRequestMessages(\Thallium\Controllers\MainController $controller)
    {
        $this->assertTrue($controller->processRequestMessages());
    }

    /**
     * a test for the getNamespacePrefix() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testInit
     */
    public function testGetNamespacePrefix(\Thallium\Controllers\MainController $controller)
    {
        $this->assertStringMatchesFormat('%s', $controller->getNamespacePrefix());
    }

    /**
     * a test for the setNamespacePrefix() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testInit
     * @expectedException \Thallium\Controllers\ExceptionController
     */
    public function testSetNamespacePrefix(\Thallium\Controllers\MainController $controller)
    {
        $this->expectException($controller->setNamespacePrefix(1));
        $this->assertTrue($controller->setNamespacePrefix('1'));
        $this->assertTrue($controller->setNamespacePrefix('ThalliumTests'));
    }

    /**
     * a test for the getRegisteredModels() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testInit
     */
    public function testGetRegisteredModels(\Thallium\Controllers\MainController $controller)
    {
        $retval = $controller->getRegisteredModels();
        $this->assertInternalType('array', $retval);
        $this->assertNotEmpty($retval);
        $this->assertNotEmpty($retval, 'JobModel');
    }

    /**
     * a test for the registerModel() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testInit
     * @expectedException \Thallium\Controllers\ExceptionController
     */
    public function testRegisterModel(\Thallium\Controllers\MainController $controller)
    {
        $this->assertFalse($controller->registerModel(null, ''));
        $this->assertFalse($controller->registerModel('', ''));
        $this->assertFalse($controller->registerModel('1'));
        $this->assertFalse($controller->registerModel('1', '1'));
        $this->assertFalse($controller->registerModel(1, 1));
        $this->assertTrue($controller->registerModel('TestModel', 'test'));
    }

    /**
     * a test for the isRegisteredModel() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testInit
     * @depends testRegisterModel
     * @expectedException \Thallium\Controllers\ExceptionController
     */
    public function testIsRegisteredModel(\Thallium\Controllers\MainController $controller)
    {
        $this->assertFalse($controller->isRegisteredModel(null, ''));
        $this->assertFalse($controller->isRegisteredModel('', ''));
        $this->assertFalse($controller->isRegisteredModel('1'));
        $this->assertFalse($controller->isRegisteredModel('1', '1'));
        $this->assertFalse($controller->isRegisteredModel(1, 1));
 
        $this->assertTrue($controller->isRegisteredModel('TestModel'));
        $this->assertTrue($controller->isRegisteredModel('TestModel', 'test'));
        $this->assertTrue($controller->isRegisteredModel(null, 'test'));
    }

    /**
     * a test for the getModelByNick() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testInit
     * @depends testRegisterModel
     * @expectedException \Thallium\Controllers\ExceptionController
     */
    public function testGetModelByNick(\Thallium\Controllers\MainController $controller)
    {
        $this->assertFalse($controller->getModelByNick('1'));
        $this->assertFalse($controller->getModelByNick(1, 1));
        $this->assertTrue($controller->getModelByNick('test'));
    }

    /**
     * a test for the isBelowDirectory() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testInit
     * @expectedException \Thallium\Controllers\ExceptionController
     */
    public function testIsBelowDirectory(\Thallium\Controllers\MainController $controller)
    {
        $this->assertFalse($controller->isBelowDirectory(null, ''));
        $this->assertFalse($controller->isBelowDirectory('', ''));
        $this->assertFalse($controller->isBelowDirectory('1'));
        $this->assertFalse($controller->isBelowDirectory('1', '1'));
        $this->assertFalse($controller->isBelowDirectory(1, 1));
 
        $this->assertFalse($controller->isBelowDirectory('/tmp', '/usr'));
        $this->assertFalse($controller->isBelowDirectory('/usr', '/tmp'));
        $this->assertFalse($controller->isBelowDirectory('/', '/tmp'));

        $this->assertTrue($controller->isBelowDirectory('/tmp', '/'));
    }

    /**
     * a test for the flushOutputBufferToLog() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testInit
     */
    public function testFlushOutputBufferToLog(\Thallium\Controllers\MainController $controller)
    {
        $this->assertTrue($controller->flushOutputBufferToLog());
    }

    /**
     * a test for the getFullModelName() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testInit
     * @depends testRegisterModel
     * @depends testSetNamespacePrefix
     * @expectedException \Thallium\Controllers\ExceptionController
     */
    public function testGetFullModelName(\Thallium\Controllers\MainController $controller)
    {
        $this->assertFalse($controller->getFullModelName('1'));
        $this->assertFalse($controller->getFullModelName(1, 1));

        $this->assertEquals('Thallium\Models\TestModel', $controller->getFullModelName('TestModel'));
    }
}

// vim: set filetype=php expandtab softtabstop=4 tabstop=4 shiftwidth=4:
