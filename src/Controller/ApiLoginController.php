<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use OpenApi\Attributes as OA;


class ApiLoginController extends AbstractController
{
    private $jwtEncoder;

    public function __construct(JWTEncoderInterface $jwtEncoder)
    {
        $this->jwtEncoder = $jwtEncoder;
    }

    #[Route('/api/login2', name: 'app_api_login', methods: ['POST'])]
    #[OA\Response(
        response: 200,
        description: 'Récupère le token JWT'
    )]
    #[OA\Tag(name: 'Login')]
    public function login(SerializerInterface $serializer, Request $request, UserRepository $userRepository): Response 
    {
        $user = $serializer->deserialize($request->getContent(), User::class, "json");
        // dd($user);
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
