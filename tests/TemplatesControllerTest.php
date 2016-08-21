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
 * This file is used to test Thalliums TemplatesController.
 *
 * @license AGPL3
 * @copyright 2015-2016 Andreas Unterkircher <unki@netshadow.net>
 * @author Andreas Unterkircher <unki@netshadow.net>
 */
namespace Thallium\Tests;

use PHPUnit\Framework\TestCase;

class TemplatesControllerTest extends TestCase
{
    /**
     * instances the TemplatesController.
     * All other tests are depending on this method.
     *
     * @params none
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     */
    public function testConstruct()
    {
        $controller = new \Thallium\Controllers\TemplatesController;
        $this->assertInstanceOf('\Thallium\Controllers\TemplatesController', $controller);

        return $controller;
    }

    /**
     * a test for the getuid() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testGetuid(\Thallium\Controllers\TemplatesController $controller)
    {
        $this->assertNotFalse($controller->getuid());
    }

    /**
     * a test for the templateExists() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testTemplateExists(\Thallium\Controllers\TemplatesController $controller)
    {
        $this->assertFalse($controller->templateExists('foobar.tpl'));
        $this->assertTrue($controller->templateExists('footer.tpl'));
    }

    /**
     * a test for the fetch() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testTemplateExists
     */
    public function testFetch(\Thallium\Controllers\TemplatesController $controller)
    {
        $this->assertNotFalse($controller->fetch('footer.tpl'));
    }

    /**
     * a test for the assign() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testAssign(\Thallium\Controllers\TemplatesController $controller)
    {
        $this->assertTrue($controller->assign('foo', 'bar'));
    }

    /**
     * a test for the registerPlugin() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testRegisterPlugin(\Thallium\Controllers\TemplatesController $controller)
    {
        $this->assertTrue($controller->registerPlugin(
            'function',
            'phpunit',
            function () {},
            false
        ));
    }

    /**
     * a test for the hasPlugin() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testRegisterPlugin
     */
    public function testHasPlugin(\Thallium\Controllers\TemplatesController $controller)
    {
        $this->assertTrue($controller->hasPlugin('function', 'phpunit'));
    }

    /**
     * a test for the smartyRaiseError() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @expectedException \Thallium\Controllers\ExceptionController
     */
    public static function smartyRaiseError(\Thallium\Controllers\TemplatesController $controller)
    {
        $this->expectExecption($controller->raiseError('test'));
    }
}

// vim: set filetype=php expandtab softtabstop=4 tabstop=4 shiftwidth=4:
