<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 07.10.16
 * Time: 22:31
 */
$loader = require __DIR__ . '/../vendor/autoload.php';
echo "autoload " . 'Test\\' . ' to ' . __DIR__ ;
$loader->add('Test\\', __DIR__ . '/');