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
 * This file is used to test Thalliums RpcController.
 *
 * @license AGPL3
 * @copyright 2015-2016 Andreas Unterkircher <unki@netshadow.net>
 * @author Andreas Unterkircher <unki@netshadow.net>
 */
namespace Thallium\Tests;

use PHPUnit\Framework\TestCase;

class RpcControllerTest extends TestCase
{
    /**
     * instances the RpcController.
     * All other tests are depending on this method.
     *
     * @params none
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     */
    public function testConstruct()
    {
        $thallium = new \Thallium\Controllers\MainController;
        $this->assertTrue($thallium->startup());
        $this->assertTrue($thallium->loadController('HttpRouter', 'router'));

        global $router;

        if (($GLOBALS['query'] = $router->select()) === false) {
            static::raiseError(__METHOD__ .'(), HttpRouterController::select() returned false!', true);
            return;
        }

        $controller = new \Thallium\Controllers\RpcController;
        $this->assertInstanceOf('\Thallium\Controllers\RpcController', $controller);

        return $controller;
    }

    /**
     * a test for the perform() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testPerform(\Thallium\Controllers\RpcController $controller)
    {
        $this->assertNotFalse($dump = $controller->perform());
        $this->assertNotEmpty($dump);
        $this->assertInternalType('string', $dump);
    }
}

// vim: set filetype=php expandtab softtabstop=4 tabstop=4 shiftwidth=4:
