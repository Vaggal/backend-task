<?php

namespace App\Controller;

use App\Utilities\Serializer;
use App\Repository\ColourRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ColourController extends AbstractController
{
    /**
     * @Route("/colours", name="getColours", methods={"GET"})
     */
    public function getColours(ColourRepository $colours, Serializer $serializer): JsonResponse
    {
        $coloursList = $colours->findAll();
        $response = $serializer->serialize($coloursList);
        return JsonResponse::fromJsonString($response);
    }
}
