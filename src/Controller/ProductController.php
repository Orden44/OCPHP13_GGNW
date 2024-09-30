<?php

namespace App\Controller;

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

        return $this->render('product/detail.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/errorPage', name: 'app_error')]
    public function error(): Response
    {
        return $this->render('error.html.twig', ['error' => 'Ce produit est inexixtant']); 
    }
}
