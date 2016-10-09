<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 08.10.16
 * Time: 0:47
 */

namespace Model;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Category
 * @package Model
 * @Entity
 * @Table(name="categories")
 */
class Category implements CategoryInterface
{

    /**
     * @var int
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $name;

    /**
     * @OneToMany(targetEntity="Book", mappedBy="category")
     * @var BookInterface[]
     */
    protected $books = null;

    /**
     * Category constructor.
     */
    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    /**
     * @param BookInterface $book
     */
    public function assignedToBook($book)
    {
        $this->books[] = $book;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return ArrayCollection|BookInterface[]
     */
    public function getBooks()
    {
        return $this->books;
    }


}