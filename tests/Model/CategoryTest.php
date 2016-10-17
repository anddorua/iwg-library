<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 08.10.16
 * Time: 0:53
 */

namespace Test\Model;

use IWG\Model\Category;
use IWG\Model\CategoryInterface;
use Test\Model\IWGModelTestCase;


class CategoryTest extends IWGModelTestCase
{

    const CAT_NAME = 'fiction';

    public function testCategoryPersist()
    {
        try {
            $category = new Category();
            $category->setName(self::CAT_NAME);
            self::$entity_manager->persist($category);
            self::$entity_manager->flush();
            $this->entityReading();
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
        $this->assertTrue(true, "category created successfully");
    }

    /**
     * @depends testCategoryPersist
     */
    public function testCategoryReading()
    {
        $this->markTestSkipped("skipped");
        $repo = self::$entity_manager->getRepository('IWG\\Model\\Category');
        /** @var $categories CategoryInterface[] */
        $categories = $repo->findAll();
        $this->assertNotEmpty($categories);
        $this->assertEquals(1, count($categories), 'categories should be counted as 1');
        $this->assertEquals(self::CAT_NAME, $categories[0]->getName(), 'category name should be same as created');
    }

    private function entityReading()
    {
        $repo = self::$entity_manager->getRepository('IWG\\Model\\Category');
        /** @var $categories CategoryInterface[] */
        $categories = $repo->findAll();
        $this->assertNotEmpty($categories);
        $this->assertEquals(1, count($categories), 'categories should be counted as 1');
        $this->assertEquals(self::CAT_NAME, $categories[0]->getName(), 'category name should be same as created');
    }
}