<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 08.10.16
 * Time: 0:31
 */

namespace Model;

/**
 * Class Book
 * @package Model
 * @Entity(repositoryClass="BookRepository")
 * @Table(name="books")
 */
class Book implements BookInterface
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     * @var int
     */
    protected $id;

    /**
     * @Column(type="string")
     * @var string
     */
    protected $name;

    /**
     * @Column(type="int")
     * @var int
     */
    protected $yearOfIssue;

    /**
     * @var
     */
    protected $author;
    protected $category;

    /**
     *
     */
    public function getId()
    {
        // TODO: Implement getId() method.
    }

    public function setName($name)
    {
        // TODO: Implement setName() method.
    }

    public function getName()
    {
        // TODO: Implement getName() method.
    }

    public function setYearOfIssue($year)
    {
        // TODO: Implement setYearOfIssue() method.
    }

    public function getYearOfIssue()
    {
        // TODO: Implement getYearOfIssue() method.
    }

    public function setAuthor($author)
    {
        // TODO: Implement setAuthor() method.
    }

    public function getAuthor()
    {
        // TODO: Implement getAuthor() method.
    }

    public function setCategory($category)
    {
        // TODO: Implement setCategory() method.
    }

    public function getCategory()
    {
        // TODO: Implement getCategory() method.
    }


}