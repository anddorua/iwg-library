<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 13.10.16
 * Time: 1:16
 */

namespace Controller;

use Doctrine\ORM\EntityManager;
use Silex\Api\ControllerProviderInterface;
use Silex\ControllerCollection;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Book implements ControllerProviderInterface
{

    public function connect(Application $app)
    {
        /** @var ControllerCollection $controllers  */
        $controllers = $app['controllers_factory'];
        $controllers->get('/', [$this, 'getList'])->bind('book-list');
        $controllers->get('/{id}', [$this, 'getSingle'])->bind('book');
        $controllers->post('/', [$this, 'postEntity']);
        $controllers->put('/{id}/category', [$this, 'putCategory']);
        return $controllers;
    }

    public function getList(Application $app, Request $request)
    {
        /** @var EntityManager $em */
        $em = $app['em'];
        $categories = $em->getRepository('Model\\Book')->findAll();
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
        $format = $app['default_format']($request);
        /** @var EntityManager $em */
        $em = $app['em'];
        $book = $em->find('Model\\Book', $id);
        if ($book === null) {
            return new Response($app['serializer']->serialize(['message' => "Book $id not found"], $format), 404, [
                'Content-Type' => $request->getMimeType($format),
            ]);
        }
        return new Response($app['serializer']->serialize($book, $format, ['groups' => ['default']]), 200, [
            'Content-Type' => $request->getMimeType($format),
        ]);
    }

    public function postEntity(Application $app, Request $request)
    {
        list($commonContentType, $requestFormat) = explode('/',$request->getContentType());
        $requestFormat = !empty($requestFormat) ? $requestFormat : $request->getContentType();
        /** @var \Model\Book $author */
        $book = $app['serializer']->deserialize(
            $request->getContent(), 'Model\\Book', $requestFormat
        );

        $format = $app['default_format']($request);
        $errors = $app['validator']->validate($book);
        if (count($errors) != 0) {
            return new Response($app['serializer']->serialize($errors, $format), 400, [
                'Content-Type' => $request->getMimeType($format),
            ]);
        }
        /** @var EntityManager $em */
        $em = $app['em'];
        $em->persist($book);
        $em->flush();
        return new Response($app['serializer']->serialize($book, $format), 201, [
            'Content-Type' => $request->getMimeType($format),
            'Location' => $app['url_generator']->generate('book', ['id' => $book->getId()]),
        ]);
    }

    public function putCategory(Application $app, Request $request, $id)
    {
        list($commonContentType, $requestFormat) = explode('/',$request->getContentType());
        $requestFormat = !empty($requestFormat) ? $requestFormat : $request->getContentType();
        /** @var \Model\Category $category */
        $category = $app['serializer']->deserialize(
            $request->getContent(), 'Model\\Category', $requestFormat
        );

        $format = $app['default_format']($request);
        /** @var EntityManager $em */
        $em = $app['em'];
        $category = $em->find('Model\\Category', $category->getId());
        if ($category === null) {
            return new Response("Category " . $category->getId() . " not found", 404, [
                'Content-Type' => $request->getMimeType($format),
            ]);
        }

        /** @var \Model\Book $book */
        $book = $em->find('Model\\Book', $id);
        if ($book === null) {
            return new Response("Book $id not found", 404, [
                'Content-Type' => $request->getMimeType($format),
            ]);
        }

        $book->setCategory($category);
        $em->persist($book);
        $em->flush();

        return new Response(null, 204, [
            'Content-Type' => $request->getMimeType($format),
        ]);
    }

}