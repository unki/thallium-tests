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
 * This file is used to test Thalliums DefaultView.
 *
 * @license AGPL3
 * @copyright 2015-2016 Andreas Unterkircher <unki@netshadow.net>
 * @author Andreas Unterkircher <unki@netshadow.net>
 */
namespace Thallium\Tests;

use PHPUnit\Framework\TestCase;

class DefaultViewTest extends TestCase
{
    /**
     * load the MainController. It is required to register models.
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
     * instances the DefaultView.
     * All other tests are depending on this method.
     *
     * @params none
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     */
    public function testConstruct()
    {
        $model = new \Thallium\Views\InternalTestView;
        $this->assertInstanceOf('\Thallium\Views\InternalTestView', $model);

        return $model;
    }

    /**
     * a test for the __set() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @expectedException \Thallium\Controllers\ExceptionController
     */
    public function testSet(\Thallium\Views\InternalTestView $model)
    {
        $model->foo = 'bar';
        $model->bar = 'foo';

        $this->expectEquals(null, $model->foo);
        $this->expectEquals('foo', $model->bar);
    }

    /**
     * a test for the addMode() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testAddMode(\Thallium\Views\InternalTestView $model)
    {
        $this->assertTrue($model->addMode('^show-.+'));
        return $model;
    }

    /**
     * a test for the isValidMode() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testAddMode
     */
    public function testIsValidMode(\Thallium\Views\InternalTestView $model)
    {
        $this->assertTrue($model->isValidMode('show-1-1'));
        $this->assertFalse($model->isValidMode('foobar'));
    }

    /**
     * a test for the getModes() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testAddMode
     */
    public function testGetModes(\Thallium\Views\InternalTestView $model)
    {
        $expect = array(
            '^list$',
            '^list-([0-9]+).html$',
            '^show$',
            '^edit$',
            'show',
            '^show-.+',
        );

        $this->assertEquals($expect, $model->getModes());
    }

    /**
     * a test for the show() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testShow(\Thallium\Views\InternalTestView $model)
    {
        $this->assertNotFalse($dump = $model->show());
    }

    /**
     * a test for the showList() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testShowList(\Thallium\Views\InternalTestView $model)
    {
        $this->assertNotFalse($dump = $model->showList());
    }

    /**
     * a test for the showEdit() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testShowEdit(\Thallium\Views\InternalTestView $model)
    {
        $this->assertNotFalse($dump = $model->showEdit(1, 1));
    }


    /**
     * a test for the dataList() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @todo need a real template to test this.
     */
    /*public function testDataList(\Thallium\Views\InternalTestView $model)
    {
        $this->assertTrue($model->dataList());
    }*/

    /**
     * a test for the addContent() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testAddContent(\Thallium\Views\InternalTestView $model)
    {
        $this->assertTrue($model->addContent('bla'));
        return $model;
    }

    /**
     * a test for the hasContent() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testAddContent
     */
    public function testHasContent(\Thallium\Views\InternalTestView $model)
    {
        $this->assertTrue($model->hasContent('bla'));
    }
}

// vim: set filetype=php expandtab softtabstop=4 tabstop=4 shiftwidth=4:
