<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 07.10.16
 * Time: 22:40
 *
 * see http://www.jeremygiberson.com
 * and http://stackoverflow.com/questions/39575292/phpunit-init-schema-with-doctrine-for-sqlite-in-memory
 */

namespace Test\Model;

use Model\Author;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit_Extensions_Database_TestCase;

class AuthorTest extends PHPUnit_Extensions_Database_TestCase
{

    /** @var  EntityManager */
    protected static $entity_manager;
    /** @var  \Doctrine\ORM\Tools\SchemaTool */
    protected static $schema_tool;

    private static function getEntityManager()
    {
        $isDevMode = true;
        $config = Setup::createAnnotationMetadataConfiguration([__DIR__ . '/../../classes/Model'], $isDevMode);
        $conn = [
            'url' => 'sqlite:///:memory:'
        ];
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
        // create entity manager following the doctrine way
        // init database schema
        // get pdo
        $pdo = self::$entity_manager->getConnection()->getWrappedConnection();
        // create connection
        return $this->createDefaultDBConnection($pdo, ':memory:');
    }

    protected function getDataSet()
    {
        return $this->createFlatXMLDataSet(__DIR__ . '/fixtures/default_data.xml');
    }


    public function testAuthorPersist()
    {
        try {
            $author = new Author();
            $author->setName('Ben');
            $author->setFName('Franklin');
            $author->setYearOfBirth(1800);
            self::$entity_manager->persist($author);
            self::$entity_manager->flush();

            $repo = self::$entity_manager->getRepository('Model\\Author');
            $authors = $repo->findAll();
            $this->assertNotEmpty($authors);
            $this->assertEquals(1, count($authors), 'authors should be counted as 1');

        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
        $this->assertTrue(true, "author created successfully");
    }

    public function testAuthorFound()
    {
        $this->markTestIncomplete('we do not save state between methods');
        $repo = self::$entity_manager->getRepository('Model\\Author');
        $authors = $repo->findAll();
        $this->assertNotEmpty($authors);
/*        $author = $repo->findOneBy(['name' => 'Ben']);
        $this->assertNotNull($author);*/
    }
}