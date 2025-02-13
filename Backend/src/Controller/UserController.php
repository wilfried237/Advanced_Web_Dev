<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Doctrine\ORM\EntityManager;
use App\Entity\User;

class UserController
{
    private $twig;
    private $entityManager;

    public function __construct(Twig $twig, EntityManager $entityManager)
    {
        $this->twig = $twig;
        $this->entityManager = $entityManager;
    }

    public function getUsers(Request $request, Response $response, $args)
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $users = $userRepository->findAll();
        
        $response->getBody()->write(json_encode($users));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function createUser(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
        $user = new User();
        $user->setName($data['name']);
        $user->setEmail($data['email']);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $response->getBody()->write(json_encode($user));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function updateUser(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
        $user = $this->entityManager->find(User::class, $args['id']);
        if (!$user) {
            return $response->withStatus(404);
        }

        $user->setName($data['name']);
        $user->setEmail($data['email']);

        $this->entityManager->flush();

        $response->getBody()->write(json_encode($user));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function deleteUser(Request $request, Response $response, $args)
    {
        $user = $this->entityManager->find(User::class, $args['id']);
        if (!$user) {
            return $response->withStatus(404);
        }

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return $response->withStatus(204);
    }
}
