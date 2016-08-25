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
 * This file is used to test Thalliums DefaultModel.
 *
 * @license AGPL3
 * @copyright 2015-2016 Andreas Unterkircher <unki@netshadow.net>
 * @author Andreas Unterkircher <unki@netshadow.net>
 */
namespace Thallium\Tests;

use PHPUnit\Framework\TestCase;

class AuditLogModelTest extends TestCase
{
    /**
     * load the MainController.
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
     * a test perform basic checks on the model.
     *
     * @params none
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     */
    public function testBasicChecks()
    {
        $this->assertTrue(\Thallium\Models\AuditLogModel::hasModelItems());
        $this->assertFalse(\Thallium\Models\AuditLogModel::hasModelFields());
    }

    /**
     * instances the AuditLogModel.
     * All other tests are depending on this method.
     *
     * @params none
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     */
    public function testConstruct()
    {
        $model = new \Thallium\Models\AuditLogModel;
        $this->assertNotEmpty($model);
        $this->assertInstanceOf('\Thallium\Models\AuditLogModel', $model);

        $this->assertTrue($model->flush());
        return $model;
    }

    /**
     * test on adding items to the model.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testAddItems(\Thallium\Models\AuditLogModel $model)
    {
        for ($i = 0; $i < 10; $i++) {
            $item = new \Thallium\Models\AuditEntryModel;
            $this->assertTrue($item->save());
            $this->assertTrue($model->addItem($item));
        }

        $this->assertTrue($model->hasItems());

        return $model;
    }

    /**
     * test on retrieving items from the model.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testAddItems
     */
    public function testGetItems(\Thallium\Models\AuditLogModel $model)
    {
        $this->assertNotFalse($dump = $model->getItemsKeys());

        $this->assertNotEmpty($dump);
        $this->assertEquals(10, count($dump));
    }

    /**
     * test on deleting items from the model.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testAddItems
     */
    public function testDeleteItems(\Thallium\Models\AuditLogModel $model)
    {
        $this->assertTrue($model->removeItem(1));
        $this->assertTrue($model->delete());
    }
}

// vim: set filetype=php expandtab softtabstop=4 tabstop=4 shiftwidth=4:
