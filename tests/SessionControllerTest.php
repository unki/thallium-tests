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
 * This file is used to test Thalliums SessionController.
 *
 * @license AGPL3
 * @copyright 2015-2016 Andreas Unterkircher <unki@netshadow.net>
 * @author Andreas Unterkircher <unki@netshadow.net>
 */
namespace Thallium\Tests;

use PHPUnit\Framework\TestCase;

class SessionControllerTest extends TestCase
{
    /**
     * instances the SessionController.
     * All other tests are depending on this method.
     *
     * @params none
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     */
    public function testConstruct()
    {
        $controller = new \Thallium\Controllers\SessionController;
        $this->assertInstanceOf('\Thallium\Controllers\SessionController', $controller);

        return $controller;
    }

    /**
     * a test for the getOnetimeIdentifierId() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testGetOnetimeIdentifierId(\Thallium\Controllers\SessionController $controller)
    {
        $dump = $controller->getOnetimeIdentifierId('phpunit');

        $this->assertNotFalse($dump);
        $this->assertNotEmpty($dump);
        $this->assertInternalType('string', $dump);

        return $dump;
    }

    /**
     * a test for the getSessionId() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testGetSessionId(\Thallium\Controllers\SessionController $controller)
    {
        $dump = $controller->getSessionId();

        $this->assertNotFalse($dump);
        $this->assertNotEmpty($dump);
        $this->assertInternalType('string', $dump);
    }

    /**
     * a test for the setVariable() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testGetOnetimeIdentifierId
     */
    public function testSetVariable(\Thallium\Controllers\SessionController $controller, string $value)
    {
        $this->assertTrue($controller->setVariable(
            'testvar',
            $value,
            'phpunit'
        ));

        return $value;
    }

    /**
     * a test for the hasVariable() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testSetVariable
     */
    public function testHasVariable(\Thallium\Controllers\SessionController $controller)
    {
        $this->assertTrue($controller->hasVariable('testvar', 'phpunit'));
    }

    /**
     * a test for the getVariable() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testSetVariable
     * @depends testHasVariable
     */
    public function testGetVariable(\Thallium\Controllers\SessionController $controller, string $expect)
    {
        $dump = $controller->getVariable('testvar', 'phpunit');

        $this->assertNotFalse($dump);
        $this->assertNotEmpty($dump);
        $this->assertInternalType('string', $dump);
        $this->assertEquals($expect, $dump);
    }
}

// vim: set filetype=php expandtab softtabstop=4 tabstop=4 shiftwidth=4:
