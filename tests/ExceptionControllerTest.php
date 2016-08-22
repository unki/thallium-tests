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
 * This file is used to test Thalliums ExceptionController.
 *
 * @license AGPL3
 * @copyright 2015-2016 Andreas Unterkircher <unki@netshadow.net>
 * @author Andreas Unterkircher <unki@netshadow.net>
 */
namespace Thallium\Tests;

use PHPUnit\Framework\TestCase;

class ExceptionControllerTest extends TestCase
{
    protected $test_job;

    /**
     * instances the ExceptionController.
     * All other tests are depending on this method.
     *
     * @params none
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     */
    public function testConstruct()
    {
        $controller = new \Thallium\Controllers\ExceptionController('phpunit');
        $this->assertInstanceOf('\Thallium\Controllers\ExceptionController', $controller);

        return $controller;
    }

    /**
     * a test for the getText() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testGetText(\Thallium\Controllers\ExceptionController $controller)
    {
        $dump = $controller->getText();

        $this->assertNotFalse($dump);
        $this->assertNotEmpty($dump);
        $this->assertInternalType('string', $dump);
    }

    /**
     * a test for the getJson() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testGetJson(\Thallium\Controllers\ExceptionController $controller)
    {
        $dump = $controller->getJson();

        $this->assertNotFalse($dump);
        $this->assertNotEmpty($dump);
        $this->assertInternalType('string', $dump);

        $this->assertNotFalse(json_decode($dump));
    }

    /**
     * a test for the () method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testToString(\Thallium\Controllers\ExceptionController $controller)
    {
        $dump = sprintf('%s', $controller);

        $this->assertNotFalse($dump);
        $this->assertNotEmpty($dump);
        $this->assertInternalType('string', $dump);
    }

    /**
     * a test for the isStopExecution() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testIsStopExecution(\Thallium\Controllers\ExceptionController $controller)
    {
        $this->assertFalse($controller->isStopExecution());
    }
}

// vim: set filetype=php expandtab softtabstop=4 tabstop=4 shiftwidth=4:
