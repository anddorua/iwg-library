<?php
/**
 * Model/Author.php
 *
 * Created by PhpStorm.
 * User: andrey
 * Date: 07.10.16
 * Time: 21:40
 */

namespace Model;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Author
 * @package Model
 * @Entity
 * @Table(name="authors")
 */
class Author implements AuthorInterface
{
    /**
     * @var int
     * @Id @Column(type="integer")
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
     * @var string
     * @Column(type="string")
     * @Groups({"default"})
     */
    protected $fName;

    /**
     * @var int
     * @Column(type="integer")
     * @Groups({"default"})
     */
    protected $yearOfBirth;


    /**
     * @ManyToMany(targetEntity="Book", mappedBy="authors")
     * @var BookInterface[]
     */
    protected $books = null;

    /**
     * Author constructor.
     */
    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\NotBlank());
        $metadata->addPropertyConstraint('fName', new Assert\NotBlank());
        $metadata->addPropertyConstraint('yearOfBirth', new Assert\NotBlank());
        $metadata->addPropertyConstraint('yearOfBirth', new Assert\Type(['type' => 'integer']));
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

    public function setFName($fName)
    {
        $this->fName = $fName;
    }

    public function getFName()
    {
        return $this->fName;
    }

    public function setYearOfBirth($year)
    {
        $this->yearOfBirth = $year;
    }

    public function getYearOfBirth()
    {
        return $this->yearOfBirth;
    }

    public function assignedBook($book)
    {
        $this->books[] = $book;
    }


}