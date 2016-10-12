<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 08.10.16
 * Time: 0:47
 */

namespace Model;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Groups({"default"})
     */
    protected $id;

    /**
     * @var string
     * @Column(type="string")
     * @Groups({"default"})
     */
    protected $name;

    /**
     * @OneToMany(targetEntity="Book", mappedBy="category")
     * @var BookInterface[]
     */
    protected $books = null;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\NotBlank());
    }

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
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
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