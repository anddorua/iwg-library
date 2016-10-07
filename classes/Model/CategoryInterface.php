<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 06.10.16
 * Time: 22:28
 */

namespace Model;


interface CategoryInterface
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
}