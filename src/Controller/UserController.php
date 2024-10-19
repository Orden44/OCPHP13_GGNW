<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CustomerOrderRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository,
        private CustomerOrderRepository $orderRepository,
        private EntityManagerInterface $entityManager
    )
    {
    }

    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        $user = $this->getUser();
        $orders = $this->orderRepository->findBy(['byUser' => $user]);

        return $this->render('user/index.html.twig', [
            'orders' => $orders,
        ]);
    }

    #[Route('/user/api/enabled', name: 'app_user_api_enabled')]
    public function enabledApiAccess(): Response
    {
        $user = $this->getUser();
        
        $user->setApiEnabled(true);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_user');
    }

    #[Route('/user/api/disabled', name: 'app_user_api_disabled')]
    public function disabledApiAccess(): Response
    {
        $user = $this->getUser();

        $user->setApiEnabled(false);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_user');
    }

    #[Route('/user/delete', name: 'app_user_delete')]
    public function deleteUser(): Response
    {
        $user = $this->getUser();

        $session = new Session();
        $session->invalidate();

        $this->entityManager->remove($user);
        $this->entityManager->flush();
        
        return $this->redirectToRoute('app_login');
    }
}
