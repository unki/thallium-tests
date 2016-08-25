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

class AuditEntryModelTest extends TestCase
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
        $this->assertTrue(\Thallium\Models\AuditEntryModel::hasModelFields());
        $this->assertFalse(\Thallium\Models\AuditEntryModel::hasModelItems());
    }

    /**
     * instances the AuditEntryModel.
     * All other tests are depending on this method.
     *
     * @params none
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     */
    public function testConstruct()
    {
        $model = new \Thallium\Models\AuditEntryModel;
        $this->assertNotEmpty($model);
        $this->assertInstanceOf('\Thallium\Models\AuditEntryModel', $model);

        return $model;
    }

    /**
     * a test for the setMessage() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testSetMessage(\Thallium\Models\AuditEntryModel $model)
    {
        $this->assertTrue($model->setMessage('hello'));
        return $model;
    }

    /**
     * instances the DefaultModel.
     * All other tests are depending on this method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSetMessage
     */
    public function testHasMessage(\Thallium\Models\AuditEntryModel $model)
    {
        $this->assertTrue($model->hasMessage());
    }

    /**
     * a test for the getMessage() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSetMessage
     */
    public function testGetMessage(\Thallium\Models\AuditEntryModel $model)
    {
        $this->assertEquals('hello', $model->getMessage());
    }

    /**
     * a test for the setEntryType() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testSetEntryType(\Thallium\Models\AuditEntryModel $model)
    {
        $this->assertTrue($model->setEntryType('foobar'));
        return $model;
    }

    /**
     * a test for the hasEntryType() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSetEntryType
     */
    public function testHasEntryType(\Thallium\Models\AuditEntryModel $model)
    {
        $this->assertTrue($model->hasEntryType());
    }

    /**
     * a test for the getEntryType() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSetEntryType
     */
    public function testGetEntryType(\Thallium\Models\AuditEntryModel $model)
    {
        $this->assertEquals('foobar', $model->getEntryType());
    }

    /**
     * a test for the setScene() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testSetScene(\Thallium\Models\AuditEntryModel $model)
    {
        $this->assertTrue($model->setScene('midgard'));
        return $model;
    }

    /**
     * a test for the hasScene() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSetScene
     */
    public function testHasScene(\Thallium\Models\AuditEntryModel $model)
    {
        $this->assertTrue($model->hasScene());
    }

    /**
     * a test for the getScene() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSetScene
     */
    public function testGetScene(\Thallium\Models\AuditEntryModel $model)
    {
        $this->assertEquals('midgard', $model->getScene());
    }

    /**
     * a test for the setEntryGuid() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testSetEntryGuid(\Thallium\Models\AuditEntryModel $model)
    {
        $this->assertTrue($model->setEntryGuid(
            '0123456789012345678901234567890123456789012345678901234567890123'
        ));

        return $model;
    }

    /**
     * a test for the hasEntryGuid() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSetEntryGuid
     */
    public function testHasEntryGuid(\Thallium\Models\AuditEntryModel $model)
    {
        $this->assertTrue($model->hasEntryGuid());
    }

    /**
     * a test for the getEntryGuid() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSetEntryGuid
     */
    public function testGetEntryGuid(\Thallium\Models\AuditEntryModel $model)
    {
        $this->assertEquals(
            '0123456789012345678901234567890123456789012345678901234567890123',
            $model->getEntryGuid()
        );
    }

    /**
     * a test for the save() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testSave(\Thallium\Models\AuditEntryModel $model)
    {
        $this->assertTrue($model->save());
        $this->assertTrue($model->hasIdx());

        return $model;
    }

    /**
     * a test for the __clone() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSave
     */
    public function testClone(\Thallium\Models\AuditEntryModel $model)
    {
        $clone = clone $model;

        $this->assertNotFalse($orig_guid = $model->getGuid());
        $this->assertNotFalse($clone_guid = $clone->getGuid());
        $this->assertNotEquals($orig_guid, $clone_guid);

        $this->assertTrue($clone->delete());
    }

    /**
     * a test for the delete() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSave
     */
    public function testDelete(\Thallium\Models\AuditEntryModel $model)
    {
        $this->assertTrue($model->delete());
    }
}

// vim: set filetype=php expandtab softtabstop=4 tabstop=4 shiftwidth=4:
