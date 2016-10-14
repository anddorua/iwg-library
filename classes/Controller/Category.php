<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 09.10.16
 * Time: 18:23
 */

namespace Controller;

use Exception\EOperationDeny;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\ORM\EntityManager;
use Exception\EModel;
use Silex\ControllerCollection;
use Silex\Application;
use JMS\Serializer;

class Category extends UnifiedController
{
    public function __construct()
    {
        $this->entityClass = 'Model\\Category';
    }


    public function connect(Application $app)
    {
        /** @var ControllerCollection $controllers  */
        $controllers = $app['controllers_factory'];
        $controllers->get('/', [$this, 'getListUnified'])->bind('category-list');
        $controllers->get('/{id}', [$this, 'getSingleUnified'])->bind('category');
        $controllers->post('/', [$this, 'postEntityUnified']);
        $controllers->put('/{id}', [$this, 'putEntityUnified']);
        $controllers->delete('/{id}', [$this, 'deleteSingleUnified']);
        return $controllers;
    }

    protected function testCanDelete($author)
    {
        if ($author->getBooks()->count() > 0) {
            throw new EOperationDeny("Category linked to books.", 409);
        }
    }

    protected function getEntityLocation(Application $app, $entity)
    {
        return $app['url_generator']->generate('category', ['id' => $entity->getId()]);
    }

    /**
     * @param EntityManager $em
     * @param int $id
     * @return \Model\Category
     * @throws EModel
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public static function findCategory(EntityManager $em, $id)
    {
        return self::findSingleEntity($em, 'Model\\Category', $id);
    }

    protected function assignOwnFields($entityDest, $entitySrc)
    {
        $entityDest->assignOwnFields($entitySrc);
    }


}
