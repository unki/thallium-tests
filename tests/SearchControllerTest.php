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
 * This file is used to test Thalliums SearchController.
 *
 * @license AGPL3
 * @copyright 2015-2016 Andreas Unterkircher <unki@netshadow.net>
 * @author Andreas Unterkircher <unki@netshadow.net>
 */
namespace Thallium\Tests;

use PHPUnit\Framework\TestCase;

class SearchControllerTest extends TestCase
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

        $this->assertTrue($thallium->registerModel('test', 'TestModel'));

        /*$model = new \Thallium\Models\AuditEntryModel;

        $this->assertTrue($model->setMessage('foobar'));
        $this->assertTrue($model->save());*/
    }

    /**
     * instances the SearchController.
     * All other tests are depending on this method.
     *
     * @params none
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     */
    public function testConstruct()
    {
        $controller = new \Thallium\Controllers\SearchController;
        $this->assertInstanceOf('\Thallium\Controllers\SearchController', $controller);

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
    public function testSearch(\Thallium\Controllers\SearchController $controller)
    {
        $this->assertTrue($controller->search('test'));
        return $controller;
    }

    /**
     * a test for the hasResults() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSearch
     */
    public function testHasResults(\Thallium\Controllers\SearchController $controller)
    {
        $this->assertTrue($controller->hasResults());
    }

    /**
     * a test for the getResults() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSearch
     */
    public function testGetResults(\Thallium\Controllers\SearchController $controller)
    {
        $dump = $controller->getResults();

        $this->assertNotFalse($dump);
        $this->assertNotEmpty($dump);
        $this->assertInternalType('array', $dump);
        $this->assertEquals(1, count($dump));

        $this->assertTrue(array_key_exists('\Thallium\Models\AuditLogModel', $dump));
        $entries = $dump['\Thallium\Models\AuditLogModel'];

        $this->assertNotFalse($entries);
        $this->assertNotEmpty($entries);
        $this->assertInternalType('array', $entries);
        $this->assertEquals(1, count($entries));

        $entry = $entries[0];

        $this->assertNotFalse($entry);
        $this->assertNotEmpty($entry);
        $this->assertInternalType('array', $entry);
        $this->assertEquals(7, count($entry));

        $this->assertTrue(array_key_exists('audit_type', $entry));
        $this->assertTrue(array_key_exists('audit_scene', $entry));
        $this->assertTrue(array_key_exists('audit_message', $entry));
        $this->assertTrue(array_key_exists('audit_time', $entry));
        $this->assertTrue(array_key_exists('audit_object_guid', $entry));

        $this->assertNotEmpty($entry['audit_type']);
        $this->assertNotEmpty($entry['audit_scene']);
        $this->assertNotEmpty($entry['audit_message']);
        $this->assertNotEmpty($entry['audit_time']);
        $this->assertNotEmpty($entry['audit_object_guid']);
    }
}

// vim: set filetype=php expandtab softtabstop=4 tabstop=4 shiftwidth=4:
