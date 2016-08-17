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
 * This file is used to test Thalliums CacheController.
 *
 * @license AGPL3
 * @copyright 2015-2016 Andreas Unterkircher <unki@netshadow.net>
 * @author Andreas Unterkircher <unki@netshadow.net>
 */
namespace Thallium\Tests;

use PHPUnit\Framework\TestCase;

class CacheControllerTest extends TestCase
{
    /**
     * instances the CacheController.
     * All other tests are depending on this method.
     *
     * @params none
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     */
    public function testConstruct()
    {
        //$thallium = new \Thallium\Controllers\MainController('install');

        $controller = new \Thallium\Controllers\CacheController;
        $this->assertInstanceOf('\Thallium\Controllers\CacheController', $controller);

        return $controller;
    }

    /**
     * a test for the add() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testAdd(\Thallium\Controllers\CacheController $controller)
    {
        $testobj = new \Thallium\Models\MessageModel;
        $this->assertEquals('testobj', $controller->add($testobj, 'testobj'));
    }

    /**
     * a test for the get() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testAdd
     */
    public function testGet(\Thallium\Controllers\CacheController $controller)
    {
        $testobj = $controller->get('testobj');

        $this->assertNotFalse($testobj);
        $this->assertTrue(is_a($testobj, 'Thallium\Models\MessageModel'));
    }

    /**
     * a test for the has() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testAdd
     */
    public function testHas(\Thallium\Controllers\CacheController $controller)
    {
        $this->assertTrue($controller->has('testobj'));
    }

    /**
     * a test for the dump() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testAdd
     */
    public function testDump(\Thallium\Controllers\CacheController $controller)
    {
        $dump = $controller->dump();
        $this->assertInternalType('array', $dump);
        $this->assertNotEmpty($dump);
    }

     /**
     * a test for the dumpIndex() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testAdd
     */
    public function testDumpIndex(\Thallium\Controllers\CacheController $controller)
    {
        $dump = $controller->dumpIndex();
        $this->assertInternalType('array', $dump);
        $this->assertNotEmpty($dump);
    }

    /**
     * a test for the del() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testAdd
     */
    public function testDel(\Thallium\Controllers\CacheController $controller)
    {
        $this->assertTrue($controller->del('testobj'));
        $this->assertFalse($controller->has('testobj'));
    }
}

// vim: set filetype=php expandtab softtabstop=4 tabstop=4 shiftwidth=4:
