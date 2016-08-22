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
 * This file is used to test Thalliums DatabaseController.
 *
 * @license AGPL3
 * @copyright 2015-2016 Andreas Unterkircher <unki@netshadow.net>
 * @author Andreas Unterkircher <unki@netshadow.net>
 */
namespace Thallium\Tests;

use PHPUnit\Framework\TestCase;

class DatabaseControllerTest extends TestCase
{
    /**
     * instances the DatabaseController.
     * All other tests are depending on this method.
     *
     * @params none
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     */
    public function testConstruct()
    {
        $controller = new \Thallium\Controllers\DatabaseController;
        $this->assertInstanceOf('\Thallium\Controllers\DatabaseController', $controller);

        return $controller;
    }

    /**
     * a test for the hasTablePrefix() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testHasTablePrefix(\Thallium\Controllers\DatabaseController $controller)
    {
        $this->assertTrue($controller->hasTablePrefix());
    }

    /**
     * a test for the getTablePrefix() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testHasTablePrefix
     */
    public function testGetTablePrefix(\Thallium\Controllers\DatabaseController $controller)
    {
        $prefix = $controller->getTablePrefix();

        $this->assertNotFalse($prefix);
        $this->assertEquals('thallium_', $prefix);
    }

    /**
     * a test for the insertTablePrefix() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testGetTablePrefix
     */
    public function testInsertTablePrefix(\Thallium\Controllers\DatabaseController $controller)
    {
        $query = "SELECT meta_key, meta_value FROM TABLEPREFIXmeta WHERE meta_key LIKE 'framework_schema_version'";
        $expect = "SELECT meta_key, meta_value FROM thallium_meta WHERE meta_key LIKE 'framework_schema_version'";

        $controller->insertTablePrefix($query);

        $this->assertEquals($expect, $query);
    }

    /**
     * a test for the getDatabaseTables() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testGetDatabaseTables(\Thallium\Controllers\DatabaseController $controller)
    {
        $tables = $controller->getDatabaseTables();

        $this->assertNotFalse($tables);
        $this->assertContains('thallium_meta', $tables);

        return $tables;
    }

    /**
     * a test for the checkTableExists() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testGetDatabaseTables
     */
    public function testCheckTableExists(\Thallium\Controllers\DatabaseController $controller)
    {
        $this->assertTrue($controller->checkTableExists('TABLEPREFIXmeta'));
    }

    /**
     * a test for the getColumns() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testCheckTableExists
     */
    public function testGetColumns(\Thallium\Controllers\DatabaseController $controller)
    {
        $result = $controller->getColumns('TABLEPREFIXmeta');

        $this->assertNotFalse($result);
        $this->assertInternalType('array', $result);
    }

    /**
     * a test for the checkColumnExists() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testGetColumns
     */
    public function testCheckColumnExists(\Thallium\Controllers\DatabaseController $controller)
    {
        $this->assertTrue($controller->checkColumnExists(
            'TABLEPREFIXmeta',
            'meta_key'
        ));
    }

    /**
     * a test for the setDatabaseSchemaVersion() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testSetDatabaseSchemaVersion(\Thallium\Controllers\DatabaseController $controller)
    {
        $this->assertTrue($controller->setDatabaseSchemaVersion(
            \Thallium\Controllers\DatabaseController::FRAMEWORK_SCHEMA_VERSION,
            'framework'
        ));

        $this->assertTrue($controller->setDatabaseSchemaVersion(
            \Thallium\Controllers\DatabaseController::SCHEMA_VERSION,
            'application'
        ));
    }

    /**
     * a test for the getApplicationDatabaseSchemaVersion() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testSetDatabaseSchemaVersion
     */
    public function testGetApplicationDatabaseSchemaVersion(\Thallium\Controllers\DatabaseController $controller)
    {
        $result = $controller->getApplicationDatabaseSchemaVersion();

        $this->assertNotFalse($result);
        $this->assertInternalType('int', $result);
    }

    /**
     * a test for the getFrameworkDatabaseSchemaVersion() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testSetDatabaseSchemaVersion
     */
    public function testGetFrameworkDatabaseSchemaVersion(\Thallium\Controllers\DatabaseController $controller)
    {
        $result = $controller->getFrameworkDatabaseSchemaVersion();

        $this->assertNotFalse($result);
        $this->assertInternalType('int', $result);
    }

    /**
     * a test for the getApplicationSoftwareSchemaVersion() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testGetApplicationSoftwareSchemaVersion(\Thallium\Controllers\DatabaseController $controller)
    {
        $result = $controller->getApplicationSoftwareSchemaVersion();

        $this->assertNotFalse($result);
        $this->assertInternalType('int', $result);
    }

    /**
     * a test for the getFrameworkSoftwareSchemaVersion() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testGetFrameworkSoftwareSchemaVersion(\Thallium\Controllers\DatabaseController $controller)
    {
        $result = $controller->getFrameworkSoftwareSchemaVersion();

        $this->assertNotFalse($result);
        $this->assertInternalType('int', $result);
    }

    /**
     * a test for the checkDatabaseSoftwareVersion() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testCheckDatabaseSoftwareVersion(\Thallium\Controllers\DatabaseController $controller)
    {
        $this->assertTrue($controller->checkDatabaseSoftwareVersion());
    }

    /**
     * a test for the query() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testCheckColumnExists
     */
    public function testQuery(\Thallium\Controllers\DatabaseController $controller)
    {
        $result = $controller->query(
            "SELECT
                meta_key,
                meta_value
            FROM
                TABLEPREFIXmeta
            WHERE
                meta_key LIKE 'framework_schema_version'"
        );

        $this->assertNotFalse($result);
        $this->assertInstanceOf('\PDOStatement', $result);

        $this->assertGreaterThanOrEqual(1, $result->rowCount());

        $row = $result->fetch();

        $this->assertNotFalse($row);
        $this->assertNotEmpty($row);
        $this->assertInternalType('object', $row);

        $this->assertNotEmpty($row->meta_key);
        $this->assertNotEmpty($row->meta_value);
        $this->assertEquals('framework_schema_version', $row->meta_key);
    }

    /**
     * a test for the prepare() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testPrepare(\Thallium\Controllers\DatabaseController $controller)
    {
        $sth = $controller->prepare(
            "SELECT
                meta_key,
                meta_value
            FROM
                TABLEPREFIXmeta
            WHERE
                meta_key LIKE ?"
        );

        $this->assertNotFalse($sth);
        $this->assertInstanceOf('\PDOStatement', $sth);

        return $sth;
    }

    /**
     * a test for the execute() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testPrepare
     */
    public function testExecute(\Thallium\Controllers\DatabaseController $controller, \PDOStatement $sth)
    {
        $result = $sth->execute(array(
            'framework_schema_version'
        ));

        $this->assertNotFalse($result);

        $this->assertGreaterThanOrEqual(1, $sth->rowCount());
        $row = $sth->fetch();

        $this->assertNotFalse($row);
        $this->assertNotEmpty($row);
        $this->assertInternalType('object', $row);

        $this->assertNotEmpty($row->meta_key);
        $this->assertNotEmpty($row->meta_value);
        $this->assertEquals('framework_schema_version', $row->meta_key);
    }

    /**
     * a test for the freeStatement() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testPrepare
     * @depends testExecute
     */
    public function testFreeStatement(\Thallium\Controllers\DatabaseController $controller, \PDOStatement $sth)
    {
        $this->assertTrue($controller->freeStatement($sth));
    }

    /**
     * a test for the fetchSingleRow() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testFetchSingleRow(\Thallium\Controllers\DatabaseController $controller)
    {
        $result = $controller->query(
            "SELECT
                meta_key,
                meta_value
            FROM
                TABLEPREFIXmeta
            WHERE
                meta_key LIKE 'framework_schema_version'",
            \PDO::FETCH_ASSOC
        );

        $this->assertNotFalse($result);
        $this->assertGreaterThanOrEqual(1, $result->rowCount());

        $row = $result->fetch();

        $this->assertNotFalse($row);
        $this->assertNotEmpty($row);
        $this->assertInternalType('array', $row);

        $this->assertNotEmpty($row['meta_key']);
        $this->assertNotEmpty($row['meta_value']);
        $this->assertEquals('framework_schema_version', $row['meta_key']);
    }

    /**
     * a test for the buildQuery() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testBuildQuery(\Thallium\Controllers\DatabaseController $controller)
    {
        $bind_params = array();
        $expect = "SELECT meta_key, meta_value FROM TABLEPREFIXmeta WHERE 0 LIKE :v_0 meta_idx IS NOT NULL";

        $result = $controller->buildQuery(
            "SELECT",
            'TABLEPREFIXmeta',
            array(
                'meta_key',
                'meta_value'
            ),
            array('meta_key LIKE ?'),
            $bind_params,
            'meta_idx IS NOT NULL'
        );

        $this->assertEquals($expect, $result);
    }

    /**
     * a test for the getId() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testGetId(\Thallium\Controllers\DatabaseController $controller)
    {
        $controller->query(
            "REPLACE INTO TABLEPREFIXmeta (
                meta_key,
                meta_value
            ) VALUES (
                'phpunit',
                'test'
            )"
        );

        $id = $controller->getId();

        $this->assertNotFalse($id);
        $this->assertTrue(is_numeric($id));
    }

    /**
     * a test for the transactions
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testGetId
     * @depends testFreeStatement
     */
    public function testTransactions(\Thallium\Controllers\DatabaseController $controller)
    {
        $this->assertTrue($controller->newTransaction());

        $sth = $controller->prepare(
            "DELETE FROM
                TABLEPREFIXmeta
            WHERE
                meta_key LIKE ?
            AND
                meta_value LIKE ?"
        );

        $this->assertNotFalse($sth);
        $this->assertInstanceOf('\PDOStatement', $sth);

        $this->assertTrue($controller->execute($sth, array(
            'phpunit',
            'test'
        )));

        $this->assertTrue($controller->freeStatement($sth));
        $this->assertTrue($controller->closeTransaction());
    }

    /**
     * a test for the quote() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testQuote(\Thallium\Controllers\DatabaseController $controller)
    {
        $result = $controller->quote("SELECT \0x ;FLSAS\"!§?\"IO°Ä L");

        $this->assertNotFalse($result);
    }

    /**
     * a test for the truncateDatabaseTables() method.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     */
    public function testTruncateDatabaseTables(\Thallium\Controllers\DatabaseController $controller)
    {
        $this->assertTrue($controller->truncateDatabaseTables());
    }

    /**
     * a test to delete all tables.
     *
     * afterwards the InstallerController is invoked to restore the tables.
     *
     * @params object $controller
     * @returns void
     * @throws \Thallium\Controllers\ExceptionController
     * @depends testConstruct
     * @depends testGetDatabaseTables
     * @depends testTruncateDatabaseTables
     */
    public function testDeleteTables(\Thallium\Controllers\DatabaseController $controller, array $tables)
    {
        $this->assertTrue($controller->newTransaction());

        foreach ($tables as $table) {
            $sth = $controller->query(sprintf('DROP TABLE %s', $table));

            $this->assertNotFalse($sth);
            $this->assertInstanceOf('\PDOStatement', $sth);
        }

        $this->assertTrue($controller->closeTransaction());

        $installer = new \Thallium\Controllers\InstallerController;
        $this->assertTrue($installer->setup());
    }
}

// vim: set filetype=php expandtab softtabstop=4 tabstop=4 shiftwidth=4:
