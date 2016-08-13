<?php

namespace Thallium\Tests;

use PHPUnit\Framework\TestCase;

class MainControllerTest extends TestCase
{
    public function testInit()
    {
        $controller = new \Thallium\Controllers\MainController;

        $this->assertInstanceOf('\Thallium\Controllers\MainController', $controller);
        return $controller;
    }

    /**
     * @depends testInit
     */
    public function testInTestMode(\Thallium\Controllers\MainController $controller)
    {
        $this->assertTrue($controller->inTestMode());
        return $controller;
    }

    /**
     * @depends testInit
     */
    public function testStartup(\Thallium\Controllers\MainController $controller)
    {
        $this->assertTrue($controller->startup());
    }

    /**
     * @depends testInit
     */
    public function testRunBackgroundJobs(\Thallium\Controllers\MainController $controller)
    {
        $this->assertTrue($controller->runBackgroundJobs());
    }

    /**
     * @depends testInit
     */
    public function testSetVerbosity(\Thallium\Controllers\MainController $controller)
    {
        $this->assertTrue($controller->setVerbosity(LOG_DEBUG));
    }

    /**
     * @depends testInit
     */
    public function testIsValidId(\Thallium\Controllers\MainController $controller)
    {
        $this->assertFalse($controller->isValidId(''));
        $this->assertFalse($controller->isValidId('test'));
        $this->assertTrue($controller->isValidId('1'));
        $this->assertTrue($controller->isValidId(2));
    }

    /**
     * @depends testInit
     */
    public function isValidModel(\Thallium\Controllers\MainController $controller)
    {
        $this->assertFalse($controller->isValidModel());
        $this->assertFalse($controller->isValidModel(''));
        $this->assertFalse($controller->isValidModel('1'));
        $this->assertFalse($controller->isValidModel(1));
        $this->assertTrue($controller->isValidModel('MessageBusModel'));
    }

    /**
     * @depends testInit
     */
    public function testIsValidGuidSyntax(\Thallium\Controllers\MainController $controller)
    {
        $this->assertFalse($controller->isValidGuidSyntax(''));
        $this->assertFalse($controller->isValidGuidSyntax('1'));
        $this->assertFalse($controller->isValidGuidSyntax(1));
        $this->assertTrue(
            $controller->isValidGuidSyntax('0123456789012345678901234567890123456789012345678901234567890123')
        );
    }

    /**
     * @depends testInit
     * @expectedException \Thallium\Controllers\ExceptionController
     */
    public function testParseId(\Thallium\Controllers\MainController $controller)
    {
        $this->assertFalse($controller->parseId(''));
        $this->assertFalse($controller->parseId('1'));
        $this->assertFalse($controller->parseId(1));
        $this->assertFalse($controller->parseId('message'));
        $this->assertFalse($controller->parseId('message-1'));
        $this->assertFalse($controller->parseId('message-1-2'));
        $this->assertTrue(
            $controller->parseId('message-1-0123456789012345678901234567890123456789012345678901234567890123')
        );
    }

    /**
     * @depends testInit
     */
    public function testCreateGuid(\Thallium\Controllers\MainController $controller)
    {
        $this->assertStringMatchesFormat('%s', $controller->createGuid());
        $this->assertEquals(64, strlen($controller->createGuid()));
    }

    /**
     * @depends testInit
     * @expectedException \Thallium\Controllers\ExceptionController
     */
    public function testLoadModel(\Thallium\Controllers\MainController $controller)
    {
        $this->expectException($controller->loadModel('MessageModel', 1, null));
        $this->expectException($controller->loadModel('MessageModel', '1x', null));
        $this->expectException($controller->loadModel('MessageModel', 1, 1));
        $this->expectException($controller->loadModel(
            'MessageModel',
            1,
            '0123456789012345678901234567890123456789012345678901234567890123'
        ));
    }

    /**
     * @depends testInit
     */
    public function testCheckUpgrade(\Thallium\Controllers\MainController $controller)
    {
        $this->assertFalse($controller->checkUpgrade());
    }

    /**
     * @depends testInit
     */
    public function testLoadController(\Thallium\Controllers\MainController $controller)
    {
        $retval = $controller->loadController('MessageBusController', 'mbus');
        $this->assertTrue($retval);
    }

    /**
     * @depends testInit
     */
    public function testGetProcessUserId(\Thallium\Controllers\MainController $controller)
    {
        $this->assertThat(
            $controller->getProcessUserId(),
            $this->greaterThanOrEqual(1)
        );
    }

    /**
     * @depends testInit
     */
    public function testGetProcessGroupId(\Thallium\Controllers\MainController $controller)
    {
        $this->assertThat(
            $controller->getProcessGroupId(),
            $this->greaterThanOrEqual(1)
        );
    }

    /**
     * @depends testInit
     */
    public function testGetProcessUserName(\Thallium\Controllers\MainController $controller)
    {
        $this->assertStringMatchesFormat('%s', $controller->getProcessUserName());
    }

    /**
     * @depends testInit
     */
    public function testGetProcessGroupName(\Thallium\Controllers\MainController $controller)
    {
        $this->assertStringMatchesFormat('%s', $controller->getProcessGroupName());
    }

    /**
     * @depends testInit
     */
    public function testProcessRequestMessages(\Thallium\Controllers\MainController $controller)
    {
        $this->assertTrue($controller->processRequestMessages());
    }

    /**
     * @depends testInit
     */
    public function testGetNamespacePrefix(\Thallium\Controllers\MainController $controller)
    {
        $this->assertStringMatchesFormat('%s', $controller->getNamespacePrefix());
    }

    /**
     * @depends testInit
     * @expectedException \Thallium\Controllers\ExceptionController
     */
    public function testSetNamespacePrefix(\Thallium\Controllers\MainController $controller)
    {
        $this->expectException($controller->setNamespacePrefix(1));
        $this->assertTrue($controller->setNamespacePrefix('1'));
        $this->assertTrue($controller->setNamespacePrefix('ThalliumTests'));
    }

    /**
     * @depends testInit
     */
    public function testGetRegisteredModels(\Thallium\Controllers\MainController $controller)
    {
        $retval = $controller->getRegisteredModels();
        $this->assertInternalType('array', $retval);
        $this->assertNotEmpty($retval);
        $this->assertNotEmpty($retval, 'JobModel');
    }

    /**
     * @depends testInit
     * @expectedException \Thallium\Controllers\ExceptionController
     */
    public function testRegisterModel(\Thallium\Controllers\MainController $controller)
    {
        $this->assertFalse($controller->registerModel(null, ''));
        $this->assertFalse($controller->registerModel('', ''));
        $this->assertFalse($controller->registerModel('1'));
        $this->assertFalse($controller->registerModel('1', '1'));
        $this->assertFalse($controller->registerModel(1, 1));
        $this->assertTrue($controller->registerModel('TestModel', 'test'));
    }

    /**
     * @depends testInit
     * @depends testRegisterModel
     * @expectedException \Thallium\Controllers\ExceptionController
     */
    public function testIsRegisteredModel(\Thallium\Controllers\MainController $controller)
    {
        $this->assertFalse($controller->isRegisteredModel(null, ''));
        $this->assertFalse($controller->isRegisteredModel('', ''));
        $this->assertFalse($controller->isRegisteredModel('1'));
        $this->assertFalse($controller->isRegisteredModel('1', '1'));
        $this->assertFalse($controller->isRegisteredModel(1, 1));
 
        $this->assertTrue($controller->isRegisteredModel('TestModel'));
        $this->assertTrue($controller->isRegisteredModel('TestModel', 'test'));
        $this->assertTrue($controller->isRegisteredModel(null, 'test'));
    }

    /**
     * @depends testInit
     * @depends testRegisterModel
     * @expectedException \Thallium\Controllers\ExceptionController
     */
    public function testGetModelByNick(\Thallium\Controllers\MainController $controller)
    {
        $this->assertFalse($controller->getModelByNick('1'));
        $this->assertFalse($controller->getModelByNick(1, 1));
        $this->assertTrue($controller->getModelByNick('test'));
    }

    /**
     * @depends testInit
     * @expectedException \Thallium\Controllers\ExceptionController
     */
    public function testIsBelowDirectory(\Thallium\Controllers\MainController $controller)
    {
        $this->assertFalse($controller->isBelowDirectory(null, ''));
        $this->assertFalse($controller->isBelowDirectory('', ''));
        $this->assertFalse($controller->isBelowDirectory('1'));
        $this->assertFalse($controller->isBelowDirectory('1', '1'));
        $this->assertFalse($controller->isBelowDirectory(1, 1));
 
        $this->assertFalse($controller->isBelowDirectory('/tmp', '/usr'));
        $this->assertFalse($controller->isBelowDirectory('/usr', '/tmp'));
        $this->assertFalse($controller->isBelowDirectory('/', '/tmp'));

        $this->assertTrue($controller->isBelowDirectory('/tmp', '/'));
    }

    /**
     * @depends testInit
     */
    public function testFlushOutputBufferToLog(\Thallium\Controllers\MainController $controller)
    {
        $this->assertTrue($controller->flushOutputBufferToLog());
    }

    /**
     * @depends testInit
     * @depends testRegisterModel
     * @depends testSetNamespacePrefix
     * @expectedException \Thallium\Controllers\ExceptionController
     */
    public function testGetFullModelName(\Thallium\Controllers\MainController $controller)
    {
        $this->assertFalse($controller->getFullModelName('1'));
        $this->assertFalse($controller->getFullModelName(1, 1));

        $this->assertEquals('Thallium\Models\TestModel', $controller->getFullModelName('TestModel'));
    }
}

// vim: set filetype=php expandtab softtabstop=4 tabstop=4 shiftwidth=4:
