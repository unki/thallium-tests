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

class MessageModelTest extends TestCase
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
        $this->assertTrue(\Thallium\Models\MessageModel::hasModelFields());
        $this->assertFalse(\Thallium\Models\MessageModel::hasModelItems());
    }

    /**
     * instances the MessageModel.
     * All other tests are depending on this method.
     *
     * @params none
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     */
    public function testConstruct()
    {
        $model = new \Thallium\Models\MessageModel;
        $this->assertNotEmpty($model);
        $this->assertInstanceOf('\Thallium\Models\MessageModel', $model);

        return $model;
    }

    /**
     * a test for the setCommand() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testSetCommand(\Thallium\Models\MessageModel $model)
    {
        $this->assertTrue($model->setCommand('test'));
        return $model;
    }

    /**
     * a test for the hasCommand() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSetCommand
     */
    public function testHasCommand(\Thallium\Models\MessageModel $model)
    {
        $this->assertTrue($model->hasCommand(true));
        return $model;
    }

    /**
     * a test for the getCommand() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSetCommand
     */
    public function testGetCommand(\Thallium\Models\MessageModel $model)
    {
        $this->assertEquals('test', $model->getCommand());
    }

    /**
     * a test for the setSessionId() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testSetSessionId(\Thallium\Models\MessageModel $model)
    {
        $this->assertTrue($model->setSessionId(session_id()));
        return $model;
    }

    /**
     * a test for the hasSessionId() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSetSessionId
     */
    public function testHasSessionId(\Thallium\Models\MessageModel $model)
    {
        $this->assertTrue($model->hasSessionId());
    }

    /**
     * a test for the getSessionId() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSetSessionId
     */
    public function testGetSessionId(\Thallium\Models\MessageModel $model)
    {
        $this->assertEquals(session_id(), $model->getSessionId());
    }

    /**
     * a test for the setBody() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testSetBody(\Thallium\Models\MessageModel $model)
    {
        $this->assertTrue($model->setBody('foobar'));
        return $model;
    }

    /**
     * a test for the hasBody() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSetBody
     */
    public function testHasBody(\Thallium\Models\MessageModel $model)
    {
        $this->assertTrue($model->hasBody());
    }

    /**
     * a test for the getBody() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSetBody
     */
    public function testGetBody(\Thallium\Models\MessageModel $model)
    {
        $this->assertEquals('foobar', $model->getBody());
    }

    /**
     * a test for the getBodyRaw() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSetBody
     */
    public function testGetBodyRaw(\Thallium\Models\MessageModel $model)
    {
        $this->assertNotFalse($dump = $model->getBodyRaw());
        $this->assertNotEmpty($dump);
        $this->assertInternalType('string', $dump);
    }

    /**
     * a test for the setScope() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testSetScope(\Thallium\Models\MessageModel $model)
    {
        $this->assertTrue($model->setScope('inbound'));
        return $model;
    }

    /**
     * a test for the hasScope() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSetScope
     */
    public function testHasScope(\Thallium\Models\MessageModel $model)
    {
        $this->assertTrue($model->hasScope());
    }

    /**
     * a test for the getScope() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSetScope
     */
    public function testGetScope(\Thallium\Models\MessageModel $model)
    {
        $this->assertEquals('inbound', $model->getScope());
    }

    /**
     * a test for the isClientMessage() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSetScope
     */
    public function testIsClientMessage(\Thallium\Models\MessageModel $model)
    {
        $this->assertTrue($model->isClientMessage());
    }

    /**
     * a test for the isServerMessage() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSetScope
     */
    public function testIsServerMessage(\Thallium\Models\MessageModel $model)
    {
        $this->assertFalse($model->isServerMessage());
    }

    /**
     * a test for the setProcessingFlag() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testSetProcessingFlag(\Thallium\Models\MessageModel $model)
    {
        $this->assertTrue($model->setProcessingFlag(true));
        return $model;
    }

    /**
     * a test for the hasProcessingFlag() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSetProcessingFlag
     */
    public function testHasProcessingFlag(\Thallium\Models\MessageModel $model)
    {
        $this->assertTrue($model->hasProcessingFlag());
    }

    /**
     * a test for the getProcessingFlag() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSetProcessingFlag
     */
    public function testGetProcessingFlag(\Thallium\Models\MessageModel $model)
    {
        $this->assertEquals('Y', $model->getProcessingFlag());
    }

    /**
     * a test for the isProcessing() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSetProcessingFlag
     */
    public function testIsProcessing(\Thallium\Models\MessageModel $model)
    {
        $this->assertTrue($model->isProcessing());
    }

    /**
     * a test for the setValue() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testSetValue(\Thallium\Models\MessageModel $model)
    {
        $this->assertTrue($model->setValue('foobar'));
        return $model;
    }

    /**
     * a test for the hasValue() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSetValue
     */
    public function testHasValue(\Thallium\Models\MessageModel $model)
    {
        $this->assertTrue($model->hasValue());
    }

    /**
     * a test for the getValue() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSetValue
     */
    public function testGetValue(\Thallium\Models\MessageModel $model)
    {
        $this->assertEquals('foobar', $model->getValue());
    }

    /**
     * a test for the save() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testSave(\Thallium\Models\MessageModel $model)
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
    public function testClone(\Thallium\Models\MessageModel $model)
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
    public function testDelete(\Thallium\Models\MessageModel $model)
    {
        $this->assertTrue($model->delete());
    }
}

// vim: set filetype=php expandtab softtabstop=4 tabstop=4 shiftwidth=4:
