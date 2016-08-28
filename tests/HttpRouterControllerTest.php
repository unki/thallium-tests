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
 * This file is used to test Thalliums HttpRouterController.
 *
 * @license AGPL3
 * @copyright 2015-2016 Andreas Unterkircher <unki@netshadow.net>
 * @author Andreas Unterkircher <unki@netshadow.net>
 */
namespace Thallium\Tests;

use PHPUnit\Framework\TestCase;

class HttpRouterControllerTest extends TestCase
{
    /**
     * instances the HttpRouterController.
     * All other tests are depending on this method.
     *
     * @params none
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     */
    public function testConstruct()
    {
        $controller = new \Thallium\Controllers\HttpRouterController;
        $this->assertInstanceOf('\Thallium\Controllers\HttpRouterController', $controller);

        return $controller;
    }

    /**
     * a test for the select() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testSelect(\Thallium\Controllers\HttpRouterController $controller)
    {
        $dump = $controller->select();

        $this->assertInstanceOf('stdClass', $dump);
        $this->assertTrue(property_exists($dump, 'method'));
        $this->assertTrue(property_exists($dump, 'uri'));
        $this->assertTrue(property_exists($dump, 'view'));
        $this->assertTrue(property_exists($dump, 'params'));
        $this->assertTrue(property_exists($dump, 'call_type'));

        $this->assertEquals('GET', $dump->method);
        $this->assertEquals(sprintf(
            '/thallium/documents/show-%d-%s?testparam=foobar',
            1,
            '0123456789012345678901234567890123456789012345678901234567890123'
        ), $dump->uri);
        $this->assertEquals('documents', $dump->view);
        $this->assertInternalType('array', $dump->params);
        $this->assertNotEmpty($dump->params);
        $this->assertEquals(
            'show-1-0123456789012345678901234567890123456789012345678901234567890123',
            $dump->params[1]
        );
        $this->assertEquals(
            'testparam=foobar',
            $dump->params[2]
        );
        $this->assertEquals('common', $dump->call_type);
    }

    /**
     * a test for the isRpcCall() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testIsRpcCall(\Thallium\Controllers\HttpRouterController $controller)
    {
        $this->assertFalse($controller->isRpcCall());
    }

    /**
     * a test for the isUploadCall() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testIsUploadCall(\Thallium\Controllers\HttpRouterController $controller)
    {
        $this->assertFalse($controller->isUploadCall());
    }

    /**
     * a test for the addValidRpcAction() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testAddValidRpcAction(\Thallium\Controllers\HttpRouterController $controller)
    {
        $this->assertTrue($controller->addValidRpcAction('phpunit'));
    }

    /**
     * a test for the isValidRpcAction() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testAddValidRpcAction
     */
    public function testIsValidRpcAction(\Thallium\Controllers\HttpRouterController $controller)
    {
        $this->assertTrue($controller->isValidRpcAction('phpunit'));
        $this->assertFalse($controller->isValidRpcAction('xxxxxxx'));
    }

    /**
     * a test for the getValidRpcActions() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testGetValidRpcActions(\Thallium\Controllers\HttpRouterController $controller)
    {
        $dump = $controller->getValidRpcActions();

        $this->assertInternalType('array', $dump);
        $this->assertNotEmpty($dump);
    }

    /**
     * a test for the parseQueryParams() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testParseQueryParams(\Thallium\Controllers\HttpRouterController $controller)
    {
        $dump = $controller->parseQueryParams();

        $this->assertInternalType('array', $dump);
        $this->assertNotEmpty($dump);
    }

    /**
     * a test for the redirectTo() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testRedirectTo(\Thallium\Controllers\HttpRouterController $controller)
    {
        $this->assertTrue($controller->redirectTo('test', 'show', '1'));
    }

    /**
     * a test for the hasQueryParams() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testHasQueryParams(\Thallium\Controllers\HttpRouterController $controller)
    {
        $this->assertTrue($controller->hasQueryParams());
    }

    /**
     * a test for the getQueryParams() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testGetQueryParams(\Thallium\Controllers\HttpRouterController $controller)
    {
        $dump = $controller->getQueryParams();

        $this->assertInternalType('array', $dump);
        $this->assertNotEmpty($dump);
    }

    /**
     * a test for the hasQueryParam() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testHasQueryParam(\Thallium\Controllers\HttpRouterController $controller)
    {
        $this->assertTrue($controller->hasQueryParam(2));
    }

    /**
     * a test for the getQueryParam() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testGetQueryParam(\Thallium\Controllers\HttpRouterController $controller)
    {
        $dump = $controller->getQueryParam(2);
        $this->assertInternalType('string', $dump);
        $this->assertNotEmpty($dump);
        $this->assertEquals('testparam=foobar', $dump);
    }

    /**
     * a test for the hasQueryMethod() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testHasQueryMethod(\Thallium\Controllers\HttpRouterController $controller)
    {
        $this->assertTrue($controller->hasQueryMethod());
    }

    /**
     * a test for the getQueryMethod() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testGetQueryMethod(\Thallium\Controllers\HttpRouterController $controller)
    {
        $dump = $controller->getQueryMethod();
        $this->assertInternalType('string', $dump);
        $this->assertNotEmpty($dump);
        $this->assertEquals('testparam=foobar', $dump);
    }

    /**
     * a test for the hasQueryUri() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testHasQueryUri(\Thallium\Controllers\HttpRouterController $controller)
    {
        $this->assertTrue($controller->hasQueryUri());
    }

    /**
     * a test for the getQueryUri() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testGetQueryUri(\Thallium\Controllers\HttpRouterController $controller)
    {
        $dump = $controller->getQueryUri();
        $this->assertInternalType('string', $dump);
        $this->assertNotEmpty($dump);
        $this->assertEquals('testparam=foobar', $dump);
    }

    /**
     * a test for the hasQueryView() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testHasQueryView(\Thallium\Controllers\HttpRouterController $controller)
    {
        $this->assertTrue($controller->hasQueryView());
    }

    /**
     * a test for the getQueryView() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testGetQueryView(\Thallium\Controllers\HttpRouterController $controller)
    {
        $dump = $controller->getQueryView();
        $this->assertInternalType('string', $dump);
        $this->assertNotEmpty($dump);
        $this->assertEquals('testparam=foobar', $dump);
    }
}

// vim: set filetype=php expandtab softtabstop=4 tabstop=4 shiftwidth=4:
