<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 09.10.16
 * Time: 18:23
 */

namespace Controller;


use Doctrine\ORM\EntityManager;
use Silex\Api\ControllerProviderInterface;
use Silex\ControllerCollection;
use Silex\Application;

class Category implements ControllerProviderInterface
{

    public function connect(Application $app)
    {
        /** @var ControllerCollection $controllers  */
        $controllers = $app['controllers_factory'];
        $controllers->get('/', [$this, 'getList']);
        return $controllers;
    }

    public function getList(Application $app)
    {
        /** @var EntityManager $em */
        $em = $app['em'];
        $cats = $em->getRepository('Model\\Category')->findAll();
        return "Cats count:" . count($cats);
    }
}
