<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 09.10.16
 * Time: 14:51
 */

namespace Test\Model;

use Model\Book;
use Test\Model\IWGModelTestCase;
use Model\Author;
use Model\Category;
use Model\CategoryInterface;

class BookTest extends IWGModelTestCase
{
    private $authors = [
        ['name' => 'Ben', 'fname' => 'Franklin', 'year' => 1800],
        ['name' => 'Klifford', 'fname' => 'Simak', 'year' => 1920],
        ['name' => 'Anton', 'fname' => 'Chekhov', 'year' => 1870],
    ];
    private $categories = [
        ['name' => 'fiction'],
        ['name' => 'drama'],
        ['name' => 'tech'],
    ];
    private function makeAuthors()
    {
        array_walk($this->authors, function($author_data){
            $author = new Author();
            $author->setName($author_data['name']);
            $author->setFName($author_data['fname']);
            $author->setYearOfBirth($author_data['year']);
            self::$entity_manager->persist($author);
        });
    }

    private function makeCategories()
    {
        array_walk($this->categories, function($cat_data){
            $category = new Category();
            $category->setName($cat_data['name']);
            self::$entity_manager->persist($category);
        });
    }

    public function testSetupData()
    {
        $this->makeAuthors();
        $this->makeCategories();
        self::$entity_manager->flush();

        $repo = self::$entity_manager->getRepository('Model\\Category');
        /** @var $categories CategoryInterface[] */
        $categories = $repo->findAll();
        $this->assertNotEmpty($categories);
        $this->assertEquals(count($this->categories), count($categories), 'categories should be counted as ' . count($this->categories));

        $repo = self::$entity_manager->getRepository('Model\\Author');
        /** @var $categories CategoryInterface[] */
        $authors = $repo->findAll();
        $this->assertNotEmpty($authors);
        $this->assertEquals(count($this->authors), count($authors), 'authors should be counted as ' . count($this->authors));
    }

    public function testBookPersist()
    {
        $this->makeAuthors();
        $this->makeCategories();
        self::$entity_manager->flush();

        $dql = 'SELECT c FROM Model\\Category c WHERE c.name = :name';
        $cat_fiction = self::$entity_manager->createQuery($dql)
            ->setParameter('name', 'fiction')
            ->getSingleResult();
        $this->assertEquals('fiction', $cat_fiction->getName());


        $dql = 'SELECT a FROM Model\\Author a WHERE a.fName = :fname';
        $author = self::$entity_manager->createQuery($dql)
            ->setParameter('fname', 'Simak')
            ->getSingleResult();
        $this->assertEquals('Simak', $author->getFName());

        $book = new Book();
        $book->setName('Precious');
        $book->setYearOfIssue(1950);
        $book->assignAuthor($author);
        $book->setCategory($cat_fiction);
        self::$entity_manager->persist($book);


    }

}