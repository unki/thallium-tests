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
 * This file is used to test Thalliums MessageBusController.
 *
 * @license AGPL3
 * @copyright 2015-2016 Andreas Unterkircher <unki@netshadow.net>
 * @author Andreas Unterkircher <unki@netshadow.net>
 */
namespace Thallium\Tests;

use PHPUnit\Framework\TestCase;

class MessageBusControllerTest extends TestCase
{
    /**
     * instances the MessageBusController.
     * All other tests are depending on this method.
     *
     * @params none
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     */
    public function testConstruct()
    {
        $controller = new \Thallium\Controllers\MessageBusController;
        $this->assertInstanceOf('\Thallium\Controllers\MessageBusController', $controller);

        return $controller;
    }

    /**
     * a test for the poll() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testPoll(\Thallium\Controllers\MessageBusController $controller)
    {
        $msgs_json = $controller->poll();

        $this->assertNotFalse($msgs_json);
        $this->assertNotEmpty($msgs_json);

        $msgs_obj = json_decode($msgs_json);

        $this->assertNotFalse($msgs_obj);
        $this->assertNotEmpty($msgs_obj);
        $this->assertInstanceOf('\stdClass', $msgs_obj);
    }

    /**
     * a test for the submit() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testPoll
     */
    public function testSubmit(\Thallium\Controllers\MessageBusController $controller)
    {
        $msg_test1 = new \stdClass;
        $msg_test1->command = 'test1';

        $msg_test2 = new \stdClass;
        $msg_test2->command = 'test1';

        $msgs_raw = array(
                $msg_test1,
                $msg_test2,
                );

        $msgs_json = json_encode($msgs_raw);

        $msg_obj = new \stdClass;
        $msg_obj->count = count($msgs_raw);
        $msg_obj->size = strlen($msgs_json);
        $msg_obj->hash = sha1($msgs_json);
        $msg_obj->json = $msgs_json;

        $msg_pre = json_encode($msg_obj);
        $this->assertTrue($controller->submit($msg_pre));
    }

    /**
     * a test for the getRequestMessages() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testGetRequestMessages(\Thallium\Controllers\MessageBusController $controller)
    {
        $msgs = $controller->getRequestMessages();

        $this->assertNotFalse($msgs);
        $this->assertNotEmpty($msgs);
        $this->assertInternalType('array', $msgs);

        foreach ($msgs as $msg) {
            $this->assertNotFalse($msg);
            $this->assertNotEmpty($msg);
            $this->assertInstanceOf('\Thallium\Models\MessageModel', $msg);
        }
    }

    /**
     * a test for the sendMessageToClient() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testSendMessageToClient(\Thallium\Controllers\MessageBusController $controller)
    {
        $this->assertTrue($controller->sendMessageToClient(
            'testmessage',
            'testbody',
            '12345',
            session_id()
        ));

        $msgs_json = $controller->poll();

        $this->assertNotFalse($msgs_json);
        $this->assertNotEmpty($msgs_json);

        $msgs_obj = json_decode($msgs_json);

        $this->assertNotFalse($msgs_obj);
        $this->assertNotEmpty($msgs_obj);
        $this->assertInstanceOf('\stdClass', $msgs_obj);
    }

    /**
     * a test for the suppressOutboundMessaging() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testSuppressOutboundMessaging(\Thallium\Controllers\MessageBusController $controller)
    {
        $this->assertFalse($controller->suppressOutboundMessaging(true));
        $this->assertTrue($controller->sendMessageToClient(
            'testmessage',
            'testbody',
            1234,
            1234
        ));
    }

    /**
     * a test for the isSuppressOutboundMessaging() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testSuppressOutboundMessaging
     */
    public function testIsSuppressOutboundMessaging(\Thallium\Controllers\MessageBusController $controller)
    {
        $this->assertTrue($controller->isSuppressOutboundMessaging());
        $this->assertTrue($controller->suppressOutboundMessaging(false));
        $this->assertFalse($controller->isSuppressOutboundMessaging());
    }
}

// vim: set filetype=php expandtab softtabstop=4 tabstop=4 shiftwidth=4:
