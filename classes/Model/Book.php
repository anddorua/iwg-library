<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 08.10.16
 * Time: 0:31
 */
namespace Model;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Groups({"default"})
     */
    protected $id;

    /**
     * @Column(type="string")
     * @var string
     * @Groups({"default"})
     */
    protected $name;

    /**
     * @Column(type="integer")
     * @var int
     * @Groups({"default"})
     */
    protected $yearOfIssue;

    /**
     * @ManyToMany(targetEntity="Author", inversedBy="books")
     * @JoinTable(name="books_authors")
     * @var AuthorInterface[]
     * @Groups({"default"})
     */
    protected $authors; // many to many relation

    /**
     * @ManyToOne(targetEntity="Category", inversedBy="books")
     * @Groups({"default"})
     */
    protected $category;

    public function __construct()
    {
        $this->authors = new ArrayCollection();
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\NotBlank());
        $metadata->addPropertyConstraint('yearOfIssue', new Assert\NotBlank());
        $metadata->addPropertyConstraint('yearOfIssue', new Assert\Type(['type' => 'integer']));
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