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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Category implements ControllerProviderInterface
{

    public function connect(Application $app)
    {
        /** @var ControllerCollection $controllers  */
        $controllers = $app['controllers_factory'];
        $controllers->get('/', [$this, 'getList']);
        $controllers->get('/{id}', [$this, 'getSingle']);
        $controllers->post('/', [$this, 'postEntity']);
        return $controllers;
    }

    public function getList(Application $app, Request $request)
    {
        /** @var EntityManager $em */
        $em = $app['em'];
        $categories = $em->getRepository('Model\\Category')->findAll();
        return new Response($app['serializer']->serialize($categories, 'json'), 200, [
            'Content-Type' => $request->getMimeType('json'),
        ]);
    }

    /**
     * @param Application $app
     * @param $id integer
     * @return Response
     */
    public function getSingle(Application $app, Request $request, $id)
    {
        /** @var EntityManager $em */
        $em = $app['em'];
        $category = $em->find('Model\\Category', $id);
        if ($category === null) {
            $app->abort(404, "Category $id not found", []);
        }
        $support = ['json', 'xml'];
        $accept = array_map(function($elem){
            list($base, $specific) = explode('/', $elem);
            return $specific; }, $request->getAcceptableContentTypes());
        $using = array_intersect($accept, $support);
        $using[] = $support[0];
        $format = array_shift($using);

        return new Response($app['serializer']->serialize($category, $format), 200, [
            'Content-Type' => $request->getMimeType($format),
        ]);
    }

    public function postEntity(Application $app, Request $request)
    {
        $category = $app['serializer']->deserialize(
            $request->getContent(), 'Model\\Category', 'json'
        );
        /** @var EntityManager $em */
        $em = $app['em'];
        $em->persist($category);
        $em->flush();
        return new Response($app['serializer']->serialize($category, 'json'), 201, [
            'Content-Type' => $request->getMimeType('json'),
        ]);
    }
}
