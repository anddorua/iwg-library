<?php
/**
 * Library app
 * here is story:
 * REST API приложение “Библиотека".
 *  1. Разработать REST API.
 *      Требования:
 *  1.1. Сущность Автор.  Поля: имя, фамилия, год рождения.
 *  1.2. Сущность Категория. Поля: название.
 *  1.3. Сущность Книга. Поля: имя, дата издания. Связь с сущностями Автор и Категория.
 *  1.4. Приложение должно использовать Silex, а также PostgreSQL.
 *  1.5. Реализовать полноценный CRUD над всеми сущностями.
 * 2. Научить приложение возвращать правильный HTTP код.
 * 3. Шаблоны проектирования.
 * *4. Реализовать авторизацию (один из способов авторизации OAuth 2.0).
 * **5. Завернуть приложение в docker. Для сервера использовать nginx + php-fpm.
 * ***6. Развернуть приложение в облаке.
 *
 * see https://iwaygroup.slack.com/messages/general/
 *
 * Created by PhpStorm.
 * User: andrey
 * Date: 09.10.16
 * Time: 18:01
 */

require __DIR__ . '/vendor/autoload.php';

/** @var $app Silex\Application\ */
$app = new Silex\Application();
$app->mount('categories', new Controller\Category());

echo "done.\n";