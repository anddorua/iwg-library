<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 08.10.16
 * Time: 0:31
 */
namespace Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Book
 * @package Model
 * @Entity
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
     * @Column(type="integer")
     * @var int
     */
    protected $yearOfIssue;

    /**
     * @ManyToMany(targetEntity="Author", inversedBy="books")
     * @JoinTable(name="books_authors")
     * @var AuthorInterface[]
     */
    protected $authors; // many to many relation

    /**
     * @ManyToOne(targetEntity="Category", inversedBy="books")
     */
    protected $category;

    public function __construct()
    {
        $this->authors = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setYearOfIssue($year)
    {
        $this->yearOfIssue = $year;
    }

    public function getYearOfIssue()
    {
        return $this->yearOfIssue;
    }

    public function assignAuthor($author)
    {
        $author->assignedBook($this);
        $this->authors[] = $author;
    }

    public function getAuthors()
    {
        return $this->authors;
    }

    /**
     * @param CategoryInterface $category
     */
    public function setCategory($category)
    {
        $category->assignedToBook($this);
        $this->category = $category;
    }

    /**
     * @return CategoryInterface
     */
    public function getCategory()
    {
        return $this->category;
    }


}