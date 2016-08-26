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

class JobModelTest extends TestCase
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
        $this->assertTrue(\Thallium\Models\JobModel::hasModelFields());
        $this->assertFalse(\Thallium\Models\JobModel::hasModelItems());
    }

    /**
     * instances the JobModel.
     * All other tests are depending on this method.
     *
     * @params none
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     */
    public function testConstruct()
    {
        $model = new \Thallium\Models\JobModel;
        $this->assertNotEmpty($model);
        $this->assertInstanceOf('\Thallium\Models\JobModel', $model);

        return $model;
    }

    /**
     * a test for the setSessionId() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testSetSessionId(\Thallium\Models\JobModel $model)
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
    public function testHasSessionId(\Thallium\Models\JobModel $model)
    {
        $this->assertTrue($model->hasSessionId());
    }

    /**
     * instances the DefaultModel.
     * All other tests are depending on this method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSetSessionId
     */
    public function testGetSessionId(\Thallium\Models\JobModel $model)
    {
        $this->assertEquals(session_id(), $model->getSessionId());
    }

    /**
     * a test for the setProcessingFlag() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testSetProcessingFlag(\Thallium\Models\JobModel $model)
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
    public function testHasProcessingFlag(\Thallium\Models\JobModel $model)
    {
        $this->assertTRue($model->hasProcessingFlag());
    }

    /**
     * a test for the getProcessingFlag() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSetProcessingFlag
     */
    public function testGetProcessingFlag(\Thallium\Models\JobModel $model)
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
    public function testIsProcessing(\Thallium\Models\JobModel $model)
    {
        $this->assertTrue($model->isProcessing());
    }

    /**
     * a test for the setRequestGuid() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testSetRequestGuid(\Thallium\Models\JobModel $model)
    {
        $this->assertTrue($model->setRequestGuid(
            '0123456789012345678901234567890123456789012345678901234567890123'
        ));
        return $model;
    }

    /**
     * a test for the hasRequestGuid() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSetRequestGuid
     */
    public function testHasRequestGuid(\Thallium\Models\JobModel $model)
    {
        $this->assertTrue($model->hasRequestGuid());
    }

    /**
     * a test for the getRequestGuid() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSetRequestGuid
     */
    public function testGetRequestGuid(\Thallium\Models\JobModel $model)
    {
        $this->assertEquals(
            '0123456789012345678901234567890123456789012345678901234567890123',
            $model->getRequestGuid()
        );
    }

    /**
     * a test for the setCommand() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testSetCommand(\Thallium\Models\JobModel $model)
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
    public function testHasCommand(\Thallium\Models\JobModel $model)
    {
        $this->assertTrue($model->hasCommand());
    }

    /**
     * a test for the getCommand() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSetCommand
     */
    public function testGetCommand(\Thallium\Models\JobModel $model)
    {
        $this->assertEquals('test', $model->getCommand());
    }

    /**
     * a test for the setParameters() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testSetParameters(\Thallium\Models\JobModel $model)
    {
        $this->assertTrue($model->setParameters(array(
            'foo' => 'bar',
        )));

        return $model;
    }

    /**
     * a test for the hasParameters() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSetParameters
     */
    public function testHasParameters(\Thallium\Models\JobModel $model)
    {
        $this->assertTrue($model->hasParameters());
    }

    /**
     * a test for the getParameters() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSetParameters
     */
    public function testGetParameters(\Thallium\Models\JobModel $model)
    {
        $expect = array(
            'foo' => 'bar',
        );

        $this->assertEquals($expect, $model->getParameters());
    }

    /**
     * a test for the save() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testSave(\Thallium\Models\JobModel $model)
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
    public function testClone(\Thallium\Models\JobModel $model)
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
    public function testDelete(\Thallium\Models\JobModel $model)
    {
        $this->assertTrue($model->delete());
    }
}

// vim: set filetype=php expandtab softtabstop=4 tabstop=4 shiftwidth=4:
