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
use Model\AuthorInterface;
use Test\Model\IWGModelTestCase;

class AuthorTest extends IWGModelTestCase
{

    public function testAuthorPersist()
    {
        try {
            $author = new Author();
            $author->setName('Ben');
            $author->setFName('Franklin');
            $author->setYearOfBirth(1800);
            self::$entity_manager->persist($author);
            self::$entity_manager->flush();
            $this->authorReading();
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
        $this->assertTrue(true, "author created successfully");
    }

    /**
     * @depends testAuthorPersist
     */
    public function testAuthorReading()
    {
        $this->markTestSkipped("skipped");
        $repo = self::$entity_manager->getRepository('Model\\Author');
        /** @var  $authors AuthorInterface[] */
        $authors = $repo->findAll();
        $this->assertNotEmpty($authors);
        $this->assertEquals(1, count($authors), 'authors should be counted as 1');
        $this->assertEquals('Ben', $authors[0]->getName(), 'name should be same as created');
        $this->assertEquals('Franklin', $authors[0]->getFName(), 'FName should be same as created');
        $this->assertEquals(1800, $authors[0]->getYearOfBirth(), 'YOB should be same as created');
    }

    private function authorReading()
    {
        $repo = self::$entity_manager->getRepository('Model\\Author');
        /** @var  $authors AuthorInterface[] */
        $authors = $repo->findAll();
        $this->assertNotEmpty($authors);
        $this->assertEquals(1, count($authors), 'authors should be counted as 1');
        $this->assertEquals('Ben', $authors[0]->getName(), 'name should be same as created');
        $this->assertEquals('Franklin', $authors[0]->getFName(), 'FName should be same as created');
        $this->assertEquals(1800, $authors[0]->getYearOfBirth(), 'YOB should be same as created');
    }
}