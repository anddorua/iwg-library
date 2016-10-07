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

/**
 * Class Author
 * @package Model
 * @Entity @Table(name="authors")
 */
class Author implements AuthorInterface
{
    /**
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $name;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $fName;

    /**
     * @var int
     * @Column(type="integer")
     */
    protected $yearOfBirth;

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->$name = $name;
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

}