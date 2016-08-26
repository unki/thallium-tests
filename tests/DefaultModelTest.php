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

class DefaultModelTest extends TestCase
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
        $this->assertTrue($thallium->registerModel('tests', 'TestsModel'));
    }

    /**
     * instances the DefaultModel.
     * All other tests are depending on this method.
     *
     * @params none
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     */
    public function testConstructFieldModel()
    {
        //public function __construct($load_by = array(), $sort_order = array())
        //$model = $this->getMockForAbstractClass('\Thallium\Models\DefaultModel');

        $test = new \Thallium\Models\TestModel;
        $this->assertInstanceOf('\Thallium\Models\TestModel', $test);

        return $test;
    }

    /**
     * instances the DefaultModel.
     * All other tests are depending on this method.
     *
     * @params none
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     */
    public function testConstructItemsModel()
    {
        //public function __construct($load_by = array(), $sort_order = array())
        //$model = $this->getMockForAbstractClass('\Thallium\Models\DefaultModel');

        $tests = new \Thallium\Models\TestsModel;
        $this->assertInstanceOf('\Thallium\Models\TestsModel', $tests);

        return $tests;
    }

    /**
     * a test for the getModelName() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     * @depends testConstructItemsModel
     */
    public function testGetModelName(\Thallium\Models\TestModel $test, \Thallium\Models\TestsModel $tests)
    {
        $this->assertEquals('Thallium\Models\TestModel', $test->getModelName());
        $this->assertEquals('Thallium\Models\TestsModel', $tests->getModelName());
    }

    /**
     * a test for the getTableName() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     * @depends testConstructItemsModel
     */
    public function testGetTableName(\Thallium\Models\TestModel $test, \Thallium\Models\TestsModel $tests)
    {
        $this->assertEquals('TABLEPREFIXtests', $test->getTableName());
        $this->assertEquals('TABLEPREFIXtests', $tests->getTableName());
    }

    /**
     * a test for the hasModelFriendlyName() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     * @depends testConstructItemsModel
     */
    public function testHasModelFriendlyName(\Thallium\Models\TestModel $test, \Thallium\Models\TestsModel $tests)
    {
        $this->assertTrue($test->hasModelFriendlyName());
        $this->assertFalse($tests->hasModelFriendlyName());
    }

    /**
     * a test for the getModelFriendlyName() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     * @depends testConstructItemsModel
     * @depends testHasModelFriendlyName
     */
    public function testGetModelFriendlyName(\Thallium\Models\TestModel $test, \Thallium\Models\TestsModel $tests)
    {
        $this->assertEquals('Test', $test->getModelFriendlyName());
        //$this->expectException('Thallium\Controllers\ExceptionController', $tests->getModelFriendlyName());
    }

    /**
     * a test for the isNew() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     * @depends testConstructItemsModel
     */
    public function testIsNew(\Thallium\Models\TestModel $test, \Thallium\Models\TestsModel $tests)
    {
        $this->assertTrue($test->isNew());
        $this->assertTrue($tests->isNew());
    }

    /**
     * a test for the isNewModel() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     * @depends testConstructItemsModel
     */
    public function testIsNewModel(\Thallium\Models\TestModel $test, \Thallium\Models\TestsModel $tests)
    {
        $this->assertTrue($test->isNewModel());
        $this->assertTrue($tests->isNewModel());
    }


    /**
     * a test for the save() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     * @depends testConstructItemsModel
     */
    public function testSave(\Thallium\Models\TestModel $test, \Thallium\Models\TestsModel $tests)
    {
        $this->assertTrue($test->save());
        $this->assertFalse($test->isNew());

        return $test;
    }

    /**
     * a test for the hasIdx() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSave
     */
    public function testHasIdx(\Thallium\Models\TestModel $test)
    {
        $this->assertTrue($test->hasIdx());
    }

    /**
     * a test for the getIdx() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSave
     */
    public function testGetIdx(\Thallium\Models\TestModel $test)
    {
        $dump = $test->getIdx();
        $this->assertNotFalse($dump);
        $this->assertNotEmpty($dump);
        $this->assertTrue(is_numeric($dump));
    }

    /**
     * a test for the hasGuid() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSave
     */
    public function testHasGuid(\Thallium\Models\TestModel $test)
    {
        $this->assertTrue($test->hasGuid());
    }

    /**
     * a test for the getGuid() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSave
     */
    public function testGetGuid(\Thallium\Models\TestModel $test)
    {
        $dump = $test->getGuid();
        $this->assertNotFalse($dump);
        $this->assertNotEmpty($dump);
        $this->assertEquals(64, strlen($dump));
    }

    /**
     * a test for the setGuid() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSave
     */
    public function testSetGuid(\Thallium\Models\TestModel $test)
    {
        $this->assertTrue($test->setGuid('0123456789012345678901234567890123456789012345678901234567890123'));
    }

    /**
     * a test for the __toString() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     * @depends testConstructItemsModel
     */
    public function testToString(\Thallium\Models\TestModel $test, \Thallium\Models\TestsModel $tests)
    {
        $this->assertStringMatchesFormat('TestModel_%i_%s', sprintf('%s', $test));
        $this->assertEquals('error', sprintf('%s', $tests));
    }

   /**
     * a test for the update() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     * @depends testConstructItemsModel
     * @depends testSave
     */
    public function testUpdate(\Thallium\Models\TestModel $test, \Thallium\Models\TestsModel $tests)
    {
        $this->assertTrue($test->update(array(
            FIELD_GUID => '0123456789012345678901234567890123456789012345678901234567890123',
        )));

        $this->assertTrue($test->save());

        /*$this->assertFalse($tests->update(array(
            FIELD_GUID => '0123456789012345678901234567890123456789012345678901234567890123',
        )));*/
    }

    /**
     * a test for the exists() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     */
    public function testExists(\Thallium\Models\TestModel $test)
    {
        $this->assertTrue($test::exists(array(
            FIELD_GUID => '0123456789012345678901234567890123456789012345678901234567890123',
        )));
    }

    /**
     * a test for the delete() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     * @depends testConstructItemsModel
     * @depends testUpdate
     */
    public function testDelete(\Thallium\Models\TestModel $test, \Thallium\Models\TestsModel $tests)
    {
        $this->assertTrue($test->delete());
        $this->assertTrue($tests->delete());
    }

    /**
     * a test for the flush() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     * @depends testConstructItemsModel
     */
    public function testFlush(\Thallium\Models\TestModel $test, \Thallium\Models\TestsModel $tests)
    {
        //$this->assertFalse($test->flush());
        $this->assertTrue($tests->flush());
    }

    /**
     *********************************************************
     * fields
     *********************************************************
     */

    /**
     * a test for the hasModelFields() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     * @depends testConstructItemsModel
     */
    public function testHasFields(\Thallium\Models\TestModel $test, \Thallium\Models\TestsModel $tests)
    {
        $this->assertTrue($test->hasModelFields());
        $this->assertFalse($tests->hasModelFields());
    }

    /**
     * a test for the getModelFields() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     * @depends testConstructItemsModel
     */
    public function testGetFields(\Thallium\Models\TestModel $test, \Thallium\Models\TestsModel $tests)
    {
        $expect = array(
            'idx' => array(
                'name' => 'idx',
                'value' => '1',
                'params' => array(
                    FIELD_TYPE => FIELD_INT,
                ),
            ),
            'guid' => array(
                'name' => 'guid',
                'value' => '0123456789012345678901234567890123456789012345678901234567890123',
                'params' => array(
                    FIELD_TYPE => FIELD_GUID,
                ),
            ),
            'link' => array(
                'name' => 'link',
                'value' => null,
                'params' => array(
                    FIELD_TYPE => FIELD_INT,
                ),
            ),
            'name' => array(
                'name' => 'name',
                'value' => 'unnamed',
                'params' => array(
                    FIELD_TYPE => FIELD_STRING,
                    FIELD_LENGTH => 32,
                    FIELD_DEFAULT => 'unnamed',
                ),
            ),
        );

        $dump = $test->getModelFields();
        $this->assertEquals($expect, $dump);
    }

    /**
     * a test for the getFieldNames() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     * @depends testConstructItemsModel
     */
    public function testGetFieldNames(\Thallium\Models\TestModel $test, \Thallium\Models\TestsModel $tests)
    {
        $expect = array(
            'idx',
            'guid',
            'link',
            'name',
        );

        $dump = $test->getFieldNames();
        $this->assertEquals($expect, $dump);
    }

    /**
     * a test for the hasField() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     * @depends testConstructItemsModel
     */
    public function testHasField(\Thallium\Models\TestModel $test, \Thallium\Models\TestsModel $tests)
    {
        $this->assertTrue($test->hasField('idx'));
        $this->assertTrue($test->hasField('guid'));
        $this->assertTrue($test->hasField('link'));
        $this->assertTrue($test->hasField('name'));
        $this->assertFalse($test->hasField('foobar'));
    }

    /**
     * a test for the getFieldPrefix() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     * @depends testConstructItemsModel
     */
    public function testGetFieldPrefix(\Thallium\Models\TestModel $test, \Thallium\Models\TestsModel $tests)
    {
        $this->assertEquals('test', $test->getFieldPrefix());
    }

    /**
     * a test for the getFieldType() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     * @depends testConstructItemsModel
     */
    public function testGetFieldType(\Thallium\Models\TestModel $test, \Thallium\Models\TestsModel $tests)
    {
        $this->assertEquals(FIELD_INT, $test->getFieldType('idx'));
        $this->assertEquals(FIELD_GUID, $test->getFieldType('guid'));
        $this->assertEquals(FIELD_INT, $test->getFieldType('link'));
    }

    /**
     * a test for the hasFieldLength() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     * @depends testConstructItemsModel
     */
    public function testHasFieldLength(\Thallium\Models\TestModel $test, \Thallium\Models\TestsModel $tests)
    {
        $this->assertFalse($test->hasFieldLength('guid'));
        $this->assertTrue($test->hasFieldLength('name'));
    }

    /**
     * a test for the getFieldLength() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     * @depends testConstructItemsModel
     */
    public function testGetFieldLength(\Thallium\Models\TestModel $test, \Thallium\Models\TestsModel $tests)
    {
        $this->assertEquals(32, $test->getFieldLength('name'));
    }

    /**
     * a test for the resetFields() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     * @depends testConstructItemsModel
     */
    public function testResetFields(\Thallium\Models\TestModel $test, \Thallium\Models\TestsModel $tests)
    {
        $this->assertTrue($test->setGuid('9123456789012345678901234567890123456789012345678901234567890123'));
        $this->assertEquals('9123456789012345678901234567890123456789012345678901234567890123', $test->getGuid());
        $this->assertTrue($test->resetFields());
        $this->assertEquals('0123456789012345678901234567890123456789012345678901234567890123', $test->getGuid());
    }

    /**
     * a test for the getFieldNameFromColumn() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     * @depends testConstructItemsModel
     */
    public function testGetFieldNameFromColumn(\Thallium\Models\TestModel $test, \Thallium\Models\TestsModel $tests)
    {
        $this->assertEquals('idx', $test->getFieldNameFromColumn('test_idx'));
        $this->assertEquals('guid', $test->getFieldNameFromColumn('test_guid'));
        $this->assertEquals('link', $test->getFieldNameFromColumn('test_link'));
        $this->assertEquals('name', $test->getFieldNameFromColumn('test_name'));
    }

    /**
     * a test for the validateField() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     * @depends testConstructItemsModel
     */
    public function testValidateField(\Thallium\Models\TestModel $test, \Thallium\Models\TestsModel $tests)
    {
        $this->assertTrue($test->validateField('idx', 1));
        $this->assertFalse($test->validateField('idx', 'a'));
    }

    /**
     * a test for the hasFieldValue() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     * @depends testConstructItemsModel
     */
    public function testHasFieldValue(\Thallium\Models\TestModel $test, \Thallium\Models\TestsModel $tests)
    {
        $this->assertTrue($test->hasFieldValue('idx'));
        $this->assertTrue($test->hasFieldValue('guid'));
        $this->assertFalse($test->hasFieldValue('link'));
    }

    /**
     * a test for the setFieldValue() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     * @depends testConstructItemsModel
     */
    public function testSetFieldValue(\Thallium\Models\TestModel $test, \Thallium\Models\TestsModel $tests)
    {
        $this->assertTrue($test->setFieldValue('idx', 5));
        $this->assertTrue($test->setFieldValue('name', 'foobar'));
        return $test;
    }

    /**
     * a test for the getFieldValue() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSetFieldValue
     */
    public function testGetFieldValue(\Thallium\Models\TestModel $test)
    {
        $this->assertEquals(5, $test->getFieldValue('idx'));
    }

    /**
     * a test for the hasDefaultValue() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     * @depends testConstructItemsModel
     */
    public function testHasDefaultValue(\Thallium\Models\TestModel $test, \Thallium\Models\TestsModel $tests)
    {
        $this->assertFalse($test->hasDefaultValue('idx'));
        $this->assertFalse($test->hasDefaultValue('guid'));
        $this->assertFalse($test->hasDefaultValue('link'));
        $this->assertTrue($test->hasDefaultValue('name'));
    }

    /**
     * a test for the getDefaultValue() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     * @depends testConstructItemsModel
     */
    public function testGetDefaultValue(\Thallium\Models\TestModel $test, \Thallium\Models\TestsModel $tests)
    {
        $this->assertEquals('unnamed', $test->getDefaultValue('name'));
    }

    /**
     *********************************************************
     * virtual field tests
     *********************************************************
     */

    /**
     * a test for the addVirtualField() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     */
    public function testAddVirtualField(\Thallium\Models\TestModel $test)
    {
        $this->assertTrue($test->addVirtualField('vfield1'));
        $this->assertTrue($test->addVirtualField('vfield2'));
        return $test;
    }

    /**
     * a test for the hasVirtualFields() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testAddVirtualField
     */
    public function testHasVirtualFields(\Thallium\Models\TestModel $test)
    {
        $this->assertTrue($test->hasVirtualFields());
    }

    /**
     * a test for the getVirtualFields() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testAddVirtualField
     */
    public function testGetVirtualFields(\Thallium\Models\TestModel $test)
    {
        $expect = array(
            'vfield1',
            'vfield2',
        );

        $dump = $test->getVirtualFields();

        $this->assertEquals($expect, $dump);
    }

    /**
     * a test for the hasVirtualField() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testAddVirtualField
     */
    public function testHasVirtualField(\Thallium\Models\TestModel $test)
    {
        $this->assertTrue($test->hasVirtualField('vfield1'));
        $this->assertTrue($test->hasVirtualField('vfield2'));
        //$this->assertTrue($test->hasVirtualField(array('vfield1', 'vfield2')));
        $this->assertFalse($test->hasVirtualField('vfield3'));
    }

    /**
     * a test for the setVirtualFieldValue() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testAddVirtualField
     */
    public function testSetVirtualFieldValue(\Thallium\Models\TestModel $test)
    {
        $this->assertTrue($test->setVirtualFieldValue('vfield1', 'foobar'));
        return $test;
    }

    /**
     * a test for the hasVirtualFieldValue() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSetVirtualFieldValue
     */
    public function testHasVirtualFieldValue(\Thallium\Models\TestModel $test)
    {
        $this->assertTrue($test->hasVirtualFieldValue('vfield1'));
        //$this->assertFalse($test->hasVirtualFieldValue('vfield2'));
    }

    /**
     * a test for the getVirtualFieldValue() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSetVirtualFieldValue
     */
    public function testGetVirtualFieldValue(\Thallium\Models\TestModel $test)
    {
        $this->assertEquals('foobar', $test->getVirtualFieldValue('vfield1'));
    }

    /**
     * a test for the getVirtualFieldGetMethod() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testAddVirtualField
     */
    public function getVirtualFieldGetMethod(\Thallium\Models\TestModel $test)
    {
        $this->assertEquals('getVfield1', $test->getVirtualFieldGetMethod('vfield1'));
        $this->assertEquals('getVfield2', $test->getVirtualFieldGetMethod('vfield2'));
    }

    /**
     * a test for the getVirtualFieldSetMethod() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testAddVirtualField
     */
    public function testGetVirtualFieldSetMethod(\Thallium\Models\TestModel $test)
    {
        $this->assertEquals('setVfield1', $test->getVirtualFieldSetMethod('vfield1'));
        //$this->assertEquals('setVfield2', $test->getVirtualFieldSetMethod('vfield2'));
    }

    /**
     *********************************************************
     * items
     *********************************************************
     */

    /**
     * a test for the hasModelItemsModel() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     * @depends testConstructItemsModel
     */
    public function testHasModelItemsModel(\Thallium\Models\TestModel $test, \Thallium\Models\TestsModel $tests)
    {
        //$this->assertFalse($test->hasModelItemsModel());
        $this->assertTrue($tests->hasModelItemsModel());
    }

    /**
     * a test for the hasModelItems() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     * @depends testConstructItemsModel
     */
    public function testHasModelItems(\Thallium\Models\TestModel $test, \Thallium\Models\TestsModel $tests)
    {
        $this->assertFalse($test->hasModelItems());
        $this->assertTrue($tests->hasModelItems());
    }

    /**
     * a test for the getModelItemsModel() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructItemsModel
     */
    public function testGetModelItemsModel(\Thallium\Models\TestsModel $tests)
    {
        $this->assertEquals('TestModel', $tests->getModelItemsModel());
    }

    /**
     * a test for the addItem() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructItemsModel
     */
    public function testAddItem(\Thallium\Models\TestsModel $tests)
    {
        for ($i = 0; $i < 10; $i++) {
            $item = new \Thallium\Models\TestModel;
            $this->assertTrue($item->save());
            $this->assertTrue($tests->addItem($item));
        }

        return $tests;
    }

    /**
     * a test for the hasItems() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testAddItem
     */
    public function testHasItems(\Thallium\Models\TestsModel $tests)
    {
        $this->assertTrue($tests->hasItems());
    }

    /**
     * a test for the getItemsKeys() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testAddItem
     */
    public function testGetItemsKeys(\Thallium\Models\TestsModel $tests)
    {
        $expect = array();
        for ($i = 1; $i <= 10; $i++) {
            array_push($expect, $i);
        }

        $dump = $tests->getItemsKeys();

        $this->assertEquals($expect, $dump);
    }

    /**
     * a test for the getItems() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testAddItem
     */
    public function testGetItems(\Thallium\Models\TestsModel $tests)
    {
        $expect = array(
            0
        );

        $dump = $tests->getItems();

        $this->assertNotFalse($dump);
        $this->assertNotEmpty($dump);
        $this->assertInternalType('array', $dump);
    }

    /**
     * a test for the hasItem() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testAddItem
     */
    public function testHasItem(\Thallium\Models\TestsModel $tests)
    {
        $this->assertTrue($tests->hasItem(5));
    }


    /**
     * a test for the getItem() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testAddItem
     */
    public function testGetItem(\Thallium\Models\TestsModel $tests)
    {
        $dump = $tests->getItem(5);

        $this->assertNotFalse($dump);
        $this->assertNotEmpty($dump);
        $this->assertInternalType('object', $dump);
        $this->assertInstanceOf('\Thallium\Models\TestModel', $dump);
    }

    /**
     * a test for the getItemsCount() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testAddItem
     */
    public function testGetItemsCount(\Thallium\Models\TestsModel $tests)
    {
        $this->assertEquals(10, $tests->getItemsCount());
    }

    /**
     * a test for the deleteItems() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testAddItem
     */
    public function testDeleteItems(\Thallium\Models\TestsModel $tests)
    {
        $this->assertTrue($tests->deleteItems());
        $this->assertEquals(0, $tests->getItemsCount());
        $this->assertFalse($tests->hasItems());
    }

    /**
     *********************************************************
     * RPC tests
     *********************************************************
     */

    /**
     * a test for the permitsRpcUpdates() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     * @depends testConstructItemsModel
     */
    public function testPermitsRpcUpdates(\Thallium\Models\TestModel $test, \Thallium\Models\TestsModel $tests)
    {
        $this->assertTrue($test->permitsRpcUpdates());
        $this->assertFalse($tests->permitsRpcUpdates());
    }

    /**
     * a test for the permitsRpcUpdateToField() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     */
    public function testPermitsRpcUpdateToField(\Thallium\Models\TestModel $test)
    {
        $this->assertTrue($test->permitsRpcUpdateToField('name'));
    }

    /**
     * a test for the permitsRpcActions() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     */
    public function testPermitsRpcActions(\Thallium\Models\TestModel $test)
    {
        $this->assertTrue($test->permitsRpcActions('update'));
    }

    /**
     *********************************************************
     * set/get tests
     *********************************************************
     */

    /**
     * a test for the __set() method on an undeclared property.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     * @expectedException \Thallium\Controllers\ExceptionController
     */
    public function testSetUndeclared(\Thallium\Models\TestModel $test)
    {
        $test->test_invalid = 1;
    }

    /**
     * a test for the __set() method on a declared property.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     */
    public function testSetDeclared(\Thallium\Models\TestModel $test)
    {
        $test->test_guid = '0123456789012345678901234567890123456789012345678901234567890123';
    }

    /**
     * a test for the __get() method on an undeclared property.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     * @depends testSetUndeclared
     */
    public function testGetUndeclared(\Thallium\Models\TestModel $test)
    {
        $this->assertNull($test->test_invalid);
    }

    /**
     * a test for the __get() method on a declared property.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     * @depends testSetDeclared
     */
    public function testGetDeclared(\Thallium\Models\TestModel $test)
    {
        $this->assertEquals(
            '0123456789012345678901234567890123456789012345678901234567890123',
            $test->test_guid
        );
    }

    /**
     * a test for the createClone() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testSetFieldValue
     */
    public function testCreateClone(\Thallium\Models\TestModel $test)
    {
        $this->assertTrue($test->hasFieldValue('name'));
        $orig_name = $test->getFieldValue('name');

        $this->assertNotFalse($orig_name);
        $this->assertNotEmpty($orig_name);
        $this->assertEquals('foobar', $orig_name);

        $clone = clone $test;

        $this->assertTrue($clone->hasFieldValue('name'));
        $clone_name = $clone->getFieldValue('name');

        $this->assertNotFalse($clone_name);
        $this->assertNotEmpty($clone_name);

        $this->assertEquals($orig_name, $clone_name);

        return $clone;
    }

    /**
     * a test for the prev() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     */
    public function testPrev(\Thallium\Models\TestModel $test)
    {
        // because it is the first object.
        $this->assertFalse($test->prev());
    }

    /**
     * a test for the next() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     */
    public function testNext(\Thallium\Models\TestModel $test)
    {
        $this->assertNotFalse($test->next());
    }

    /**
     *********************************************************
     * links
     *********************************************************
     */

    /**
     * a test for the hasModelLinks() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     * @depends testConstructItemsModel
     */
    public function testHasModelLinks(\Thallium\Models\TestModel $test, \Thallium\Models\TestsModel $tests)
    {
        $this->assertTrue($test->hasModelLinks());
        $this->assertFalse($tests->hasModelLinks());
    }

    /**
     * a test for the getModelLinks() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     */
    public function testGetModelLinks(\Thallium\Models\TestModel $test)
    {
        $expect = array(
            'TestsModel/link' => 'idx'
        );

        $dump = $test->getModelLinks();

        $this->assertNotFalse($dump);
        $this->assertNotEmpty($dump);
        $this->assertInternalType('array', $dump);

        $this->assertEquals($expect, $test->getModelLinks());
    }

    /**
     * a test for the getModelLinkedList() method.
     *
     * @params object $model
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstructFieldModel
     * @depends testCreateClone
     */
    public function testGetModelLinkedList(\Thallium\Models\TestModel $test, \Thallium\Models\TestModel $clone)
    {
        $this->assertNotFalse($test_idx = $test->getIdx());
        $this->assertNotEmpty($test_idx);
        $this->assertNotFalse($clone->setFieldValue('link', $test_idx));
        $this->assertTrue($clone->save());

        $this->assertNotFalse($clone_idx = $clone->getIdx());
        $this->assertNotEmpty($clone_idx);

        $dump = $test->getModelLinkedList();

        $this->assertNotTrue($dump);
        $this->assertNotFalse($dump);
        $this->assertNotEmpty($dump);
        $this->assertEquals(1, count($dump));
        $this->assertInternalType('array', $dump);

        $link = $dump[0];

        $this->assertNotFalse($link_idx = $link->getIdx());
        $this->assertNotEmpty($link_idx);

        $this->assertEquals($clone_idx, $link_idx);
    }
}

/**
 * temporary TestModels.
 */
namespace Thallium\Models;

class TestModel extends \Thallium\Models\DefaultModel
{
    /** @var string $model_table_name */
    protected static $model_table_name = 'tests';

    /** @var string $model_column_prefix */
    protected static $model_column_prefix = 'test';

    /** @var string $model_friendl_name */
    protected static $model_friendly_name = "Test";

    /** @var array $model_fields */
    protected static $model_fields = array(
        'idx' => array(
            FIELD_TYPE => FIELD_INT,
        ),
        'guid' => array(
            FIELD_TYPE => FIELD_GUID,
        ),
        'link' => array(
            FIELD_TYPE => FIELD_INT,
        ),
        'name' => array(
            FIELD_TYPE => FIELD_STRING,
            FIELD_LENGTH => 32,
            FIELD_DEFAULT => 'unnamed',
        ),
    );

    /** @var array $model_links */
    protected static $model_links = array(
        'TestsModel/link' => 'idx',
    );

    protected $vfield1;
    protected $vfield2;

    protected function __init()
    {
        $this->permitRpcUpdates(true);
        $this->addRpcEnabledField('name');
        $this->addRpcAction('update');
        return true;
    }

    protected function setVfield1($value)
    {
        $this->vfield1 = $value;
        return true;
    }

    protected function getVfield1()
    {
        return $this->vfield1;
    }

    protected function setVfield2($value)
    {
        $this->vfield2 = $value;
        return true;
    }

    protected function getVfield2()
    {
        return $this->vfield2;
    }
}

class TestsModel extends \Thallium\Models\DefaultModel
{
     /** @var string $model_table_name */
    protected static $model_table_name = 'tests';

    /** @var string $model_column_prefix */
    protected static $model_column_prefix = 'test';

    /** @var bool $model_has_items */
    protected static $model_has_items = true;

    /** @var string $model_items_model */
    protected static $model_items_model = 'TestModel';
}

// vim: set filetype=php expandtab softtabstop=4 tabstop=4 shiftwidth=4:
