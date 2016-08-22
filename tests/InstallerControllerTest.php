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
 * This file is used to test Thalliums InstallerController.
 *
 * @license AGPL3
 * @copyright 2015-2016 Andreas Unterkircher <unki@netshadow.net>
 * @author Andreas Unterkircher <unki@netshadow.net>
 */
namespace Thallium\Tests;

use PHPUnit\Framework\TestCase;

class InstallerControllerTest extends TestCase
{
    protected $test_job;

    /**
     * instances the InstallerController.
     * All other tests are depending on this method.
     *
     * @params none
     * @returns void
     * @throws \Thallium\Controllers\InstallerController
     */
    public function testConstruct()
    {
        $controller = new \Thallium\Controllers\InstallerController;
        $this->assertInstanceOf('\Thallium\Controllers\InstallerController', $controller);

        return $controller;
    }

    /**
     * a test for the setup() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\InstallerController
     * @depends testConstruct
     */
    public function testSetup(\Thallium\Controllers\InstallerController $controller)
    {
        $this->assertTrue($controller->setup());
    }
}

// vim: set filetype=php expandtab softtabstop=4 tabstop=4 shiftwidth=4:
