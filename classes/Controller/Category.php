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
        $controllers->get('/', [$this, 'getList'])->bind('category-list');
        $controllers->get('/{id}', [$this, 'getSingle'])->bind('category');
        $controllers->post('/', [$this, 'postEntity']);
        return $controllers;
    }

    public function getList(Application $app, Request $request)
    {
        /** @var EntityManager $em */
        $em = $app['em'];
        $categories = $em->getRepository('Model\\Category')->findAll();
        $format = $app['default_format']($request);
        return new Response($app['serializer']->serialize($categories, $format, ['groups' => ['default']]), 200, [
            'Content-Type' => $request->getMimeType($format),
        ]);
    }

    /**
     * @param Application $app
     * @param $id integer
     * @param $request Request
     * @return Response
     */
    public function getSingle(Application $app, Request $request, $id)
    {
        /** @var EntityManager $em */
        $em = $app['em'];
        $category = $em->find('Model\\Category', $id);
        $format = $app['default_format']($request);
        if ($category === null) {
            return new Response($app['serializer']->serialize(['message' => "Category $id not found"], $format), 404, [
                'Content-Type' => $request->getMimeType($format),
            ]);
        }
        return new Response($app['serializer']->serialize($category, $format, ['enable_annotations' => true]), 200, [
            'Content-Type' => $request->getMimeType($format),
        ]);
    }

    public function postEntity(Application $app, Request $request)
    {
        /** @var \Model\Category $category */
        $category = $app['serializer']->deserialize(
            $request->getContent(), 'Model\\Category', 'json'
        );

        $format = $app['default_format']($request);
        $errors = $app['validator']->validate($category);
        if (count($errors) != 0) {
            return new Response($app['serializer']->serialize($errors, $format), 400, [
                'Content-Type' => $request->getMimeType($format),
            ]);
        }
        /** @var EntityManager $em */
        $em = $app['em'];
        $em->persist($category);
        $em->flush();
        return new Response($app['serializer']->serialize($category, $format), 201, [
            'Content-Type' => $request->getMimeType($format),
            'Location' => $app['url_generator']->generate('category', ['id' => $category->getId()]),
        ]);
    }
}
