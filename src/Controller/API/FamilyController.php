<?php

namespace App\Controller\API;

use App\Entity\Family;
use App\Repository\FamilyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class FamilyController extends AbstractController
{
    #[Route('/API/family', name: 'api_family')]
    public function index(FamilyRepository $familyRepository, SerializerInterface $serializer): Response
    {
        $families = $familyRepository->findAll();
        $json = $serializer->serialize($families, 'json', ['groups' => 'family:read']);
        return new Response($json, 200, ['Content-Type' => 'application/json']);
    }

    #[Route('/API/family/{id}', name: 'api_family_show')]
    public function show(Family $family, SerializerInterface $serializer): Response
    {
        $json = $serializer->serialize($family, 'json', ['groups' => 'family:read']);
        return new Response($json, 200, ['Content-Type' => 'application/json']);
    }

    #[Route('/API/family/category/{id}', name: 'api_family_category')]
    public function category(FamilyRepository $familyRepository, int $id, SerializerInterface $serializer): Response
    {
        $families = $familyRepository->findBy(['familyCategory' => $id]);
        $json = $serializer->serialize($families, 'json', ['groups' => 'family:read']);
        return new Response($json, 200, ['Content-Type' => 'application/json']);
    }
}
