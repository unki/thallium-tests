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
 * This file is used to test Thalliums JobsController.
 *
 * @license AGPL3
 * @copyright 2015-2016 Andreas Unterkircher <unki@netshadow.net>
 * @author Andreas Unterkircher <unki@netshadow.net>
 */
namespace Thallium\Tests;

use PHPUnit\Framework\TestCase;

class JobsControllerTest extends TestCase
{
    /**
     * instances the JobsController.
     * All other tests are depending on this method.
     *
     * @params none
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     */
    public function testConstruct()
    {
        $controller = new \Thallium\Controllers\JobsController;
        $this->assertInstanceOf('\Thallium\Controllers\JobsController', $controller);

        return $controller;
    }

    /**
     * a test for the registerHandler() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testRegisterHandler(\Thallium\Controllers\JobsController $controller)
    {
        $this->assertTrue($controller->registerHandler(
            'phpunit',
            function () {
                return true;
            }
        ));
    }

    /**
     * a test for the isRegisteredHandler() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testRegisterHandler
     */
    public function testIsRegisteredHandler(\Thallium\Controllers\JobsController $controller)
    {
        $this->assertTrue($controller->isRegisteredHandler('phpunit'));
    }

    /**
     * a test for the getHandler() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testRegisterHandler
     */
    public function testGetHandler(\Thallium\Controllers\JobsController $controller)
    {
        $dump = $controller->getHandler('phpunit');
        $this->assertInstanceOf('\Closure', $dump);
        $this->assertNotEmpty($dump);
    }

    /**
     * a test for the createJob() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testCreateJob(\Thallium\Controllers\JobsController $controller)
    {
        $job = $controller->createJob(
            'phpunit',
            array(
                'param1' => 'foo',
                'param2' => 'baa',
            ),
            '01234567890',
            '0123456789012345678901234567890123456789012345678901234567890123'
        );

        $this->assertInstanceOf('\Thallium\Models\JobModel', $job);
        $this->assertNotEmpty($job);
        $this->assertFalse($job->isNew());
        $this->assertTrue($job->hasGuid());

        return $job;
    }

    /**
     * a test for the setCurrentJob() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testCreateJob
     */
    public function testSetCurrentJob(\Thallium\Controllers\JobsController $controller, \Thallium\Models\JobModel $job)
    {
        $guid = $job->getGuid();
        $this->assertTrue($controller->setCurrentJob($guid));
        return $job;
    }

    /**
     * a test for the hasCurrentJob() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testSetCurrentJob
     */
    public function testHasCurrentJob(\Thallium\Controllers\JobsController $controller)
    {
        $this->assertTrue($controller->hasCurrentJob());
    }

    /**
     * a test for the getCurrentJob() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testSetCurrentJob
     */
    public function testGetCurrentJob(\Thallium\Controllers\JobsController $controller, \Thallium\Models\JobModel $job)
    {
        $want_guid = $job->getGuid();
        $is_guid = $controller->getCurrentJob();
        $this->assertEquals($want_guid, $is_guid);
    }

    /**
     * a test for the clearCurrentJob() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testGetCurrentJob
     */
    public function testClearCurrentJob(\Thallium\Controllers\JobsController $controller)
    {
        $this->assertTrue($controller->clearCurrentJob());
    }

    /**
     * a test for the runJob() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testCreateJob
     * @depends testRegisterHandler
     */
    public function testRunJob(\Thallium\Controllers\JobsController $controller, \Thallium\Models\JobModel $job)
    {
        $guid = $job->getGuid();
        $this->assertTrue($controller->runJob($guid));
    }

    /**
     * a test for the runJobs() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testRunJobs(\Thallium\Controllers\JobsController $controller)
    {
        $this->assertTrue($controller->runJobs());
    }

    /**
     * a test for the deleteJob() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testCreateJob
     * @depends testRunJob
     */
    public function testDeleteJob(\Thallium\Controllers\JobsController $controller)
    {
        $job = $controller->createJob(
            'phpunit',
            array(
                'param1' => 'foo',
                'param2' => 'baa',
            ),
            '01234567890',
            '0123456789012345678901234567890123456789012345678901234567890123'
        );

        $guid = $job->getGuid();
        $this->assertTrue($controller->deleteJob($guid));
    }

    /**
     * a test for the unregisterHandler() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testRegisterHandler
     */
    public function testUnregisterHandler(\Thallium\Controllers\JobsController $controller)
    {
        $this->assertTrue($controller->unregisterHandler('phpunit'));
    }
}

// vim: set filetype=php expandtab softtabstop=4 tabstop=4 shiftwidth=4:
