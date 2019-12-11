<?php

namespace App\Test\TestCase;

use Cake\TestSuite\Fixture\FixtureManager;
use Cake\Datasource\ConnectionManager;

class AppFixtureManager extends FixtureManager
{

    /**
     *
     * @see FixtureManager::loadSingle
     */
    public function loadSingleOrigin($fixture, $db = null, $dropTables = true)
    {
        if (!$db) {
            $db = ConnectionManager::get($fixture->connection());
        }

        if (!$this->isFixtureSetup($db->configName(), $fixture)) {
            $sources = $db->schemaCollection()->listTables();
            $this->_setupTable($fixture, $db, $sources, $dropTables);
        }

        if (!$dropTables) {
            $fixture->dropConstraints($db);
            $fixture->truncate($db);
        }

        $fixture->createConstraints($db);
        $fixture->insert($db);
    }

}
