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
 * This file is used to test Thalliums PagingController.
 *
 * @license AGPL3
 * @copyright 2015-2016 Andreas Unterkircher <unki@netshadow.net>
 * @author Andreas Unterkircher <unki@netshadow.net>
 */
namespace Thallium\Tests;

use PHPUnit\Framework\TestCase;

class PagingControllerTest extends TestCase
{
    protected $pagingData = array();

    /**
     * setup data provider.
     *
     * @params none
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     */
    public function setUp()
    {
        $thallium = new \Thallium\Controllers\MainController;
        $thallium->startup();

        $auditlog = new \Thallium\Models\AuditLogModel;

        for ($i = 0; $i < 100; $i++) {
            $entry = new \Thallium\Models\AuditEntryModel;
            $entry->save();
            $auditlog->addItem($entry);
        }

        $this->pagingData =& $auditlog;
    }

    /**
     * instances the PagingController.
     * All other tests are depending on this method.
     *
     * @params none
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     */
    public function testConstruct()
    {
        $controller = new \Thallium\Controllers\PagingController(array(
            'delta' => 2,
        ));

        $this->assertInstanceOf('\Thallium\Controllers\PagingController', $controller);
        return $controller;
    }

    /**
     * a test for the setPagingData() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testSetPagingData(\Thallium\Controllers\PagingController $controller)
    {
        $this->assertTrue($controller->setPagingData($this->pagingData));
    }

    /**
     * a test for the hasPagingData() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testSetPagingData
     */
    public function testHasPagingData(\Thallium\Controllers\PagingController $controller)
    {
        $this->assertTrue($controller->hasPagingData());
    }

    /**
     * a test for the getPageData() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testHasPagingData
     */
    public function testGetPageData(\Thallium\Controllers\PagingController $controller)
    {
        $data = $controller->getPageData();

        $this->assertNotFalse($data);
        $this->assertNotEmpty($data);

        $this->assertInternalType('array', $data);
        $this->assertEquals(10, count($data));
    }

    /**
     * a test for the getCurrentPage() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testSetPagingData
     */
    public function testGetCurrentPage(\Thallium\Controllers\PagingController $controller)
    {
        $this->assertEquals(0, $controller->getCurrentPage());
    }

    /**
     * a test for the setCurrentPage() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testGetCurrentPage
     */
    public function testSetCurrentPage(\Thallium\Controllers\PagingController $controller)
    {
        $this->assertTrue($controller->setCurrentPage(2));
    }

    /**
     * a test for the isCurrentPage() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testSetCurrentPage
     */
    public function testIsCurrentPage(\Thallium\Controllers\PagingController $controller)
    {
        $this->assertTrue($controller->isCurrentPage(2));
        $this->assertFalse($controller->isCurrentPage(1));
        $this->assertFalse($controller->isCurrentPage(0));
        $this->assertFalse($controller->isCurrentPage(-1));
    }

    /**
     * a test for the getPreviousPageNumber() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testSetCurrentPage
     */
    public function testGetPreviousPageNumber(\Thallium\Controllers\PagingController $controller)
    {
        $this->assertEquals(1, $controller->getPreviousPageNumber());
    }

    /**
     * a test for the getNextPageNumber() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testSetCurrentPage
     */
    public function testGetNextPageNumber(\Thallium\Controllers\PagingController $controller)
    {
        $this->assertEquals(3, $controller->getNextPageNumber());
    }

    /**
     * a test for the getFirstPageNumber() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testSetCurrentPage
     */
    public function testGetFirstPageNumber(\Thallium\Controllers\PagingController $controller)
    {
        $this->assertEquals(1, $controller->getFirstPageNumber());
    }

    /**
     * a test for the getLastPageNumber() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testSetCurrentPage
     */
    public function testGetLastPageNumber(\Thallium\Controllers\PagingController $controller)
    {
        $this->assertEquals(20, $controller->getLastPageNumber());
    }

    /**
     * a test for the getPageNumbers() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testSetPagingData
     */
    public function testGetPageNumbers(\Thallium\Controllers\PagingController $controller)
    {
        $pages = $controller->getPageNumbers();

        $this->assertNotFalse($pages);
        $this->assertNotEmpty($pages);

        $this->assertInternalType('array', $pages);
        $this->assertEquals(20, count($pages));
    }

    /**
     * a test for the getDeltaPageNumbers() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testSetCurrentPage
     */
    public function testGetDeltaPageNumbers(\Thallium\Controllers\PagingController $controller)
    {
        $expect = array(1, 2, 3, 4);
        $this->assertEquals($expect, ($controller->getDeltaPageNumbers()));
    }

    /**
     * a test for the isValidItemsLimit() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testIsValidItemsLimit(\Thallium\Controllers\PagingController $controller)
    {
        $this->assertTrue($controller->isValidItemsLimit(25));
        $this->assertTrue($controller->isValidItemsLimit(0));
        $this->assertFalse($controller->isValidItemsLimit(200));
        $this->assertFalse($controller->isValidItemsLimit(-1));
    }

    /**
     * a test for the setItemsLimit() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testSetPagingData
     * @depends testIsValidItemsLimit
     */
    public function testSetItemsLimit(\Thallium\Controllers\PagingController $controller)
    {
        $this->assertTrue($controller->setItemsLimit(25));
    }

    /**
     * a test for the hasItemsLimits() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testSetItemsLimit
     */
    public function testHasItemsLimits(\Thallium\Controllers\PagingController $controller)
    {
        $this->assertTrue($controller->hasItemsLimits());
    }

    /**
     * a test for the getItemsLimits() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testHasItemsLimits
     */
    public function testGetItemsLimits(\Thallium\Controllers\PagingController $controller)
    {
        $expect = array(10, 25, 50, 100, 0);
        $this->assertEquals($expect, $controller->getItemsLimits());
    }

    /**
     * a test for the getCurrentItemsLimit() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testGetItemsLimits
     * @depends testSetItemsLimit
     */
    public function testGetCurrentItemsLimit(\Thallium\Controllers\PagingController $controller)
    {
        $this->assertEquals(25, $controller->getCurrentItemsLimit());
    }

    /**
     * a test for the getFirstItemsLimit() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testGetFirstItemsLimit(\Thallium\Controllers\PagingController $controller)
    {
        $this->assertEquals(10, $controller->getFirstItemsLimit());
    }

    /**
     * a test for the isCurrentItemsLimit() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testGetCurrentItemsLimit
     */
    public function testIsCurrentItemsLimit(\Thallium\Controllers\PagingController $controller)
    {
        $this->assertTrue($controller->isCurrentItemsLimit(25));
        $this->assertFalse($controller->isCurrentItemsLimit(10));
        $this->assertFalse($controller->isCurrentItemsLimit(0));
        $this->assertFalse($controller->isCurrentItemsLimit(-1));
    }

    /**
     * a test for the getNumberOfPages() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testSetCurrentPage
     * @depends testSetItemsLimit
     */
    public function testGetNumberOfPages(\Thallium\Controllers\PagingController $controller)
    {
        $this->assertEquals(8, $controller->getNumberOfPages());
    }
}

// vim: set filetype=php expandtab softtabstop=4 tabstop=4 shiftwidth=4:
