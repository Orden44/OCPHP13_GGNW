<?php

namespace App\Controller;

use App\Entity\User;
use OpenApi\Attributes as OA;
use App\Repository\UserRepository;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;


class ApiLoginController extends AbstractController
{
    private $jwtEncoder;

    public function __construct(JWTEncoderInterface $jwtEncoder)
    {
        $this->jwtEncoder = $jwtEncoder;
    }

    #[Route('/api/login', name: 'app_api_login', methods: ['POST'])]
    #[OA\Post(
        path: "api/login",
        summary: "Permet d'obtenir le token JWT pour se logger.",
        description: "Crée un nouveau token JWT",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                type: "object",
                properties: [
                    new OA\Property(property: "username", type: "string", default: "orden@gmail.com"),
                    new OA\Property(property: "password", type: "string", default: "Motdepasse")
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Récupère le token JWT',
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "token", type: "string", example: "your_jwt_token_here")
                    ]
                )
            ),
            new OA\Response(response: 401, description: "Invalid credentials"),
            new OA\Response(response: 400, description: "Bad Request")
        ],
        tags: ["Login"]
    )]
    #[Security(name: null)]
    #[OA\Response(
        response: 200,
        description: 'Récupère le token JWT'
    )]
    #[OA\Tag(name: 'Login')]
    public function login(SerializerInterface $serializer, Request $request, UserRepository $userRepository): Response 
    {
        $user = $serializer->deserialize($request->getContent(), User::class, "json");
        $storedUser = $userRepository->findOneBy(['email' => $user->getEmail()]);
        if (!$storedUser || !password_verify($user->getPassword(), $storedUser->getPassword())) {
            return new JsonResponse(['message' => 'Identifiants incorrects'], Response::HTTP_UNAUTHORIZED);
        }

        if ($user->isApiEnabled()) {
            // Génération du token JWT
            $token = $this->jwtEncoder->encode([
                'username' => $storedUser->getEmail(),
                'exp' => time() + 7200,
            ]);    
            // Retourner la réponse JSON avec le token
            return new JsonResponse(['token' => $token]);
        } else {
            // Si l'accès à l'API est désactivé, retourner une réponse avec le statut 403 (Forbidden)
            return new JsonResponse(['message' => 'Accès API non activé'], JsonResponse::HTTP_FORBIDDEN);
        }
    }
}
