<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 06.10.16
 * Time: 22:31
 */

namespace Model;


interface BookInterface
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
     * @param $year int
     * @return void
     */
    public function setYearOfIssue($year);

    /**
     * @return int
     */
    public function getYearOfIssue();

    /**
     * @param $author AuthorInterface
     * @return void
     */
    public function setAuthor($author);

    /**
     * @return AuthorInterface
     */
    public function getAuthor();

    /**
     * @param $category CategoryInterface
     * @return void
     */
    public function setCategory($category);

    /**
     * @return CategoryInterface
     */
    public function getCategory();
}