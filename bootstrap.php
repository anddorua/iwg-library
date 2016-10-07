<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 07.10.16
 * Time: 21:10
 */

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once 'vendor/autoload.php';

$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration([__DIR__ . '/classes/Model'], $isDevMode);

/*$conn = [
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/db.sqlite',
];*/
$conn = [
    'dbname' => 'iway',
    'user' => 'iway',
    'password' => 'iway',
    'host' => 'localhost',
    'driver' => 'pdo_pgsql',
];

$entityManager = EntityManager::create($conn, $config);

/*$config = new \Doctrine\DBAL\Configuration();
$conn = \Doctrine\DBAL\DriverManager::getConnection($conn, $config);*/
