<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 08.10.16
 * Time: 0:55
 */

namespace Test\Model;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit_Extensions_Database_TestCase;


abstract class IWGModelTestCase extends PHPUnit_Extensions_Database_TestCase
{
    /** @var  EntityManager */
    protected static $entity_manager;
    /** @var  \Doctrine\ORM\Tools\SchemaTool */
    protected static $schema_tool;

    private static function getEntityManager()
    {
        $isDevMode = true;
        $config = Setup::createAnnotationMetadataConfiguration([__DIR__ . '/../../classes/Model'], $isDevMode);
        return EntityManager::create(['driver' => 'pdo_sqlite', 'memory' => true], $config);
    }

    public static function setUpBeforeClass()
    {
        self::$entity_manager = self::getEntityManager();
        self::$entity_manager->clear();
        self::$schema_tool = new SchemaTool(self::$entity_manager);
        self::$schema_tool->createSchema(self::$entity_manager->getMetadataFactory()->getAllMetadata());
    }

    public static function tearDownAfterClass()
    {
        self::$schema_tool->dropDatabase();
    }

    public function getConnection()
    {
        // get pdo
        $pdo = self::$entity_manager->getConnection()->getWrappedConnection();
        // create connection
        return $this->createDefaultDBConnection($pdo, ':memory:');
    }

    protected function getDataSet()
    {
        return $this->createFlatXMLDataSet(__DIR__ . '/fixtures/default_data.xml');
    }
}