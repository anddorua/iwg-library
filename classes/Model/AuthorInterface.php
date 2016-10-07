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
     * @param $id int
     * @return void
     */
    public function setId($id);

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
    public function setFname($fName);

    /**
     * @return string
     */
    public function getFname();

    /**
     * @param $year int
     * @return void
     */
    public function setYearofbirth($year);

    /**
     * @return int
     */
    public function getYearofbirth();
}