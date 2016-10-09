<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 06.10.16
 * Time: 22:22
 */

namespace Model;


interface AuthorInterface
{

    /**
     * @return int
     */
    public function getId();

    /**
     * @param $name string
     * @return void
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param $fName string
     * @return void
     */
    public function setFName($fName);

    /**
     * @return string
     */
    public function getFName();

    /**
     * @param $year int
     * @return void
     */
    public function setYearOfBirth($year);

    /**
     * @return int
     */
    public function getYearOfBirth();

    /**
     * @param $book BookInterface
     * @return void
     */
    public function assignedBook($book);
}