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
 * This file is used to test Thalliums SkeletonView.
 *
 * @license AGPL3
 * @copyright 2015-2016 Andreas Unterkircher <unki@netshadow.net>
 * @author Andreas Unterkircher <unki@netshadow.net>
 */
namespace Thallium\Tests;

use PHPUnit\Framework\TestCase;

class SkeletonViewTest extends TestCase
{
    /**
     * load the MainController. It is required to register
     * models.
     *
     * @params none
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     */
    public function setUp()
    {
        $thallium = new \Thallium\Controllers\MainController;
        $this->assertInstanceOf('\Thallium\Controllers\MainController', $thallium);

        $this->assertTrue($thallium->startup());
    }

    /**
     * instances the SkeletonView.
     * All other tests are depending on this method.
     *
     * @params none
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     */
    public function testConstruct()
    {
        $model = new \Thallium\Views\SkeletonView;
        $this->assertInstanceOf('\Thallium\Views\SkeletonView', $model);

        return $model;
    }

    /**
     * a test for the show() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testShow(\Thallium\Views\SkeletonView $model)
    {
        $this->assertNotFalse($dump = $model->show());
    }
}

// vim: set filetype=php expandtab softtabstop=4 tabstop=4 shiftwidth=4:
