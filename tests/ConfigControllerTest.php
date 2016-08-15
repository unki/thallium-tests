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
 * This file is used to test Thalliums ConfigController.
 *
 * @license AGPL3
 * @copyright 2015-2016 Andreas Unterkircher <unki@netshadow.net>
 * @author Andreas Unterkircher <unki@netshadow.net>
 */
namespace Thallium\Tests;

use PHPUnit\Framework\TestCase;

class ConfigControllerTest extends TestCase
{
    /**
     * instances the ConfigController.
     * All other tests are depending on this method.
     *
     * @params none
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     */
    public function testConstruct()
    {
        //$thallium = new \Thallium\Controllers\MainController('install');

        $controller = new \Thallium\Controllers\ConfigController;
        $this->assertInstanceOf('\Thallium\Controllers\ConfigController', $controller);

        return $controller;
    }

    /**
     * a test for the getDatabaseConfiguration() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testGetDatabaseConfiguration(\Thallium\Controllers\ConfigController $controller)
    {
        $retval = $controller->getDatabaseConfiguration();
        $this->assertInternalType('array', $retval);
        $this->assertNotEmpty($retval);
    }

    /**
     * a test for the getDatabaseType() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testGetDatabaseConfiguration
     */
    public function testGetDatabaseType(\Thallium\Controllers\ConfigController $controller)
    {
        $this->assertEquals('mysql', $controller->getDatabaseType());
    }

    /**
     * a test for the getWebPath() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testGetWebPath(\Thallium\Controllers\ConfigController $controller)
    {
        $this->assertEquals('/thallium', $controller->getWebPath());
    }

    /**
     * a test for the getPageTitle() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testGetPageTitle(\Thallium\Controllers\ConfigController $controller)
    {
        $this->assertEquals('Thallium', $controller->getPageTitle());
    }

    /**
     * a test for the isEnabled() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @todo currently isEnabled() is protected
     */
    /*public function testIsEnabled(\Thallium\Controllers\ConfigController $controller)
    {
        $this->assertTrue($controller->isEnabled('yes'));
        $this->assertTrue($controller->isEnabled('y'));
        $this->assertTrue($controller->isEnabled('true'));
        $this->assertTrue($controller->isEnabled('on'));
        $this->assertTrue($controller->isEnabled('1'));

        $this->assertFalse($controller->isEnabled(null));
        $this->assertFalse($controller->isEnabled(0));
        $this->assertFalse($controller->isEnabled('no'));
        $this->assertFalse($controller->isEnabled('n'));
        $this->assertFalse($controller->isEnabled('false'));
        $this->assertFalse($controller->isEnabled('off'));
        $this->assertFalse($controller->isEnabled('0'));
    }*/

    /**
     * a test for the isDisabled() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @todo currently isDisabled() is protected
     */
    /*public function testIsDisabled(\Thallium\Controllers\ConfigController $controller)
    {

        $this->assertTrue($controller->isDisabled(null));
        $this->assertTrue($controller->isDisabled(0));
        $this->assertTrue($controller->isDisabled('0'));
        $this->assertTrue($controller->isDisabled('no'));
        $this->assertTrue($controller->isDisabled('n'));
        $this->assertTrue($controller->isDisabled('false'));
        $this->assertTrue($controller->isDisabled('off'));

        $this->assertFalse($controller->isDisabled('yes'));
        $this->assertFalse($controller->isDisabled('y'));
        $this->assertFalse($controller->isDisabled('true'));
        $this->assertFalse($controller->isDisabled('on'));
        $this->assertFalse($controller->isDisabled('1'));
        $this->assertFalse($controller->isDisabled(1));
    }*/

    /**
     * a test for the inMaintenanceMode() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testInMaintenanceMode(\Thallium\Controllers\ConfigController $controller)
    {
        $this->assertFalse($controller->inMaintenanceMode());
    }
}

// vim: set filetype=php expandtab softtabstop=4 tabstop=4 shiftwidth=4:
