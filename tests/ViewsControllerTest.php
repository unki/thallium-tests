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
 * This file is used to test Thalliums ViewsController.
 *
 * @license AGPL3
 * @copyright 2015-2016 Andreas Unterkircher <unki@netshadow.net>
 * @author Andreas Unterkircher <unki@netshadow.net>
 */
namespace Thallium\Tests;

use PHPUnit\Framework\TestCase;

class ViewsControllerTest extends TestCase
{
    /**
     * instances the ViewsController.
     * All other tests are depending on this method.
     *
     * @params none
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     */
    public function testConstruct()
    {
        $controller = new \Thallium\Controllers\ViewsController;
        $this->assertInstanceOf('\Thallium\Controllers\ViewsController', $controller);

        return $controller;
    }

    /**
     * a test for the getView() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testGetView(\Thallium\Controllers\ViewsController $controller)
    {
        $view = $controller->getView('internaltestview');
        $this->assertInstanceOf('\Thallium\Views\InternalTestView', $view);
        $this->assertNotEmpty($view);
    }

    /**
     * a test for the load() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testGetView
     */
    public function testLoad(\Thallium\Controllers\ViewsController $controller)
    {
        $view = $controller->load('internaltestview', true);
        $this->assertNotFalse($view);
        $this->assertNotEmpty($view);
    }
}

// vim: set filetype=php expandtab softtabstop=4 tabstop=4 shiftwidth=4:
