<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\CartItems;
use App\Service\TotalPrice;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    public function __construct(
        private ProductRepository $productRepository,
        private EntityManagerInterface $entityManager
    )
    {     
    }

    #[Route('/cart', name: 'app_cart')]
    public function cart(): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return $this->redirectToRoute('app_login');
        }
        
        $cart = $user->getCartItems();

        $totalPrice = TotalPrice::calculate($user);

        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
            'totalPrice' => $totalPrice
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add')]
    public function addItemCart(Request $request, int $id): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return $this->redirectToRoute('app_login');
        }
        
        $product = $this->productRepository->find($id);
        $quantity = $request->request->get('quantity');

        $cartItem = new CartItems();
        $cartItem->setProduct($product);
        $cartItem->setQuantity($quantity);
        $cartItem->setUnitPrice($product->getPrice()); 

        $cartItem->setByUser($user);

        $this->entityManager->persist($cartItem);
        $this->entityManager->flush();

        $this->addFlash('success', 'le produit a été ajouté au panier');

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/update/{id}', name: 'app_cart_update')]
    public function updateItemCart(Request $request, int $id): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return $this->redirectToRoute('app_login');
        }
        
        $cartItems = $user->getCartItems();
        $product = $this->productRepository->find($id);
        $quantity = $request->request->get('quantity');
        $cartItemToUpdate = null;

        foreach ($cartItems as $cartItem) {
            $cartProduct = $cartItem->getProduct();
            if ($cartProduct->getId() === $product->getId()) {
                $cartItemToUpdate = $cartItem;
                break;
            }
        }

        if ($cartItemToUpdate) {
            if ($quantity == 0) {
                $this->entityManager->remove($cartItemToUpdate);
            } else {
                $cartItemToUpdate->setQuantity($quantity);
                $cartItemToUpdate->setUnitPrice($product->getPrice()); 
                $this->entityManager->persist($cartItemToUpdate);
            }
            $this->entityManager->flush();
        }

        $this->addFlash('success', 'Votre panier a été mis à jour');

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/empty', name: 'app_cart_empty')]
    public function emptyItemCart(): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return $this->redirectToRoute('app_login');
        }
        
        $cartItems = $user->getCartItems();

        foreach ($cartItems as $cartItem) {
            $this->entityManager->remove($cartItem);
        }   

        $this->entityManager->flush();

        return $this->redirectToRoute('app_cart');      
    }
}