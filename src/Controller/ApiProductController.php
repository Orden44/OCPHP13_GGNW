<?php

namespace App\Controller;

use OpenApi\Attributes as OA;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiProductController extends AbstractController
{
    #[Route('/api/products', name: 'products', methods: ['GET'])]
    #[OA\Get(
        summary: "Permet d'obtenir la liste des produits.",
        description: "Détail des produits de Green Goodies",
    )]
    #[OA\Response(
        response: 200,
        description: 'Retourne la liste des produits',
    )]

    #[OA\Tag(name: 'Products')]
    public function getProducts(ProductRepository $productRepository, SerializerInterface $serializer): JsonResponse
    {
        $products = $productRepository->findAll();

        $jsonProducts = $serializer->serialize($products, 'json', ['groups' => 'getProduct']);

        return new JsonResponse($jsonProducts, Response::HTTP_OK, [], true);
    }
}
