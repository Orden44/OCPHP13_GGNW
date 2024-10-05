<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    public function __construct(
        private ProductRepository $productRepository,
    )
    {
    }

    #[Route('/product', name: 'app_product')]
    public function product(): Response
    {
            $products = $this->productRepository->findAll();

            return $this->render('product/index.html.twig', [
                'products' => $products,
            ]);
    }

    #[Route('/product/{id}', name: 'app_product_detail')]
    public function detailProduct(int $id): Response
    {

        $product = $this->productRepository->find($id);

        if(!$product) {
            return $this->redirectToRoute('app_error');
        }

        $productInCart = false;
        $productQuantity = 1;

        if ($this->isGranted('ROLE_USER')) {
            $productQuantity = $this->productInCart($id);

            if ($productQuantity) {
                $productInCart = true;
            }    
        }   

        return $this->render('product/detail.html.twig', [
            'product' => $product,
            'productInCart' => $productInCart,
            'productQuantity' => $productQuantity,
        ]);
    }

    #[Route('/errorPage', name: 'app_error')]
    public function error(): Response
    {
        return $this->render('error.html.twig', ['error' => 'Ce produit est inexistant']); 
    }

    public function productInCart(int $productId)
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return false;
        }
        
        $cartItems = $user->getCartItems();

        if (!$cartItems) {
            return false;
         }

        $productInCart = false;
        $productQuantity = 0;

        foreach  ($cartItems as $cartItem) {
            $product = $cartItem->getProduct();

            if ($product && $product->getId() === $productId) {
                $productInCart = true;
                $productQuantity = $cartItem->getQuantity();
            }
        }

        return $productInCart ? $productQuantity : false;
    }
}
