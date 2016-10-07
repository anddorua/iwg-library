<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 06.10.16
 * Time: 22:48
 */

namespace Model;


class Author extends AbstractEntity implements AuthorInterface
{
    protected $_id;
    protected $_name;
    protected $_fname;
    protected $_yearofbirth;

    /**
     * Author constructor.
     * @param $_name
     * @param $_fname
     * @param $_yearofbirth
     */
    public function __construct($_name, $_fname, $_yearofbirth)
    {
        $this->setName($_name);
        $this->setFname($_fname);
        $this->setYearofbirth($_yearofbirth);
    }


}