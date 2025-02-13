<?php

require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

// Create Slim app
$app = AppFactory::create();

// Create Twig
$twig = Twig::create(__DIR__ . '/../templates', ['cache' => false]);

// Add Twig-View Middleware
$app->add(TwigMiddleware::create($app, $twig));

// Configure Doctrine ORM
$config = Setup::createAnnotationMetadataConfiguration([__DIR__ . '/../src/Entity'], true, null, null, false);
$conn = [
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/../db/database.sqlite',
];
$entityManager = EntityManager::create($conn, $config);

// Add routes
$app->get('/users', 'App\Controller\UserController:getUsers');
$app->post('/users', 'App\Controller\UserController:createUser');
$app->put('/users/{id}', 'App\Controller\UserController:updateUser');
$app->delete('/users/{id}', 'App\Controller\UserController:deleteUser');

// Run Slim app
$app->run();
