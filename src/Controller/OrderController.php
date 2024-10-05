<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\TotalPrice;
use App\Entity\CustomerOrder;
use App\Controller\CartController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private  CartController $cartController
    )
    {     
    }

    #[Route('/order', name: 'app_order')]
    public function index(): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return $this->redirectToRoute('app_login');
        }
        
        $order = new CustomerOrder();
        $order->setByUser($user);
        $order->setOrderDate(new \DateTimeImmutable());  

        $totalPrice = TotalPrice::calculate($user);
        $order->setTotalPrice($totalPrice);

        $this->entityManager->persist($order);

        $cartItems = $user->getCartItems();

        foreach ($cartItems as $cartItem) {
            $this->entityManager->remove($cartItem);
        }   

        $this->entityManager->flush();

        $this->addFlash('success', 'Votre vommande a bien été validée');

        return $this->redirectToRoute('app_user');
    }
}
