<?php

namespace App\Controller;

use App\Entity\Car;
use App\Utilities\Serializer;
use App\Repository\CarRepository;
use App\Repository\ColourRepository;
use App\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CarController extends AbstractController
{
    /**
     * @Route("/cars", name="getCars", methods={"GET"})
     */
    public function getCars(Request $request, CarRepository $cars, Serializer $serializer): JsonResponse
    {
        $carsList = $cars->findAll();
        $response = $serializer->serialize($carsList);
        return JsonResponse::fromJsonString($response);
    }

    /**
     * @Route("/car/{id}", name="getCarById", methods={"GET"}, requirements={"page"="\d+"})
     */
    public function getCarById(Request $request, $id, CarRepository $cars, Serializer $serializer): Response
    {
        $car = $cars->find($id);
        if ($car === null) {
            $response = [
                "message" => "The car does not exist."
            ];
            return new JsonResponse($response, 404);
        }
        $response = $serializer->serialize($car);
        return JsonResponse::fromJsonString($response);
    }

    /**
     * @Route("/cars", name="createCar", methods={"POST"})
     */
    public function createCar(Request $request, Serializer $serializer, CarRepository $cars, ColourRepository $colours, ValidatorInterface $validator): Response
    {
        $car = $serializer->deserialize($request->getContent(), Car::class);

        try {
            $violations = new ConstraintViolationList();
            $violations->addAll($validator->validate($car->getColour()));
            $violations->addAll($validator->validate($car));
            $violations->addAll($car->validateDate());

            if (count($violations) > 0) {
                throw new ValidationException($violations);
            }

            $colour = $colours->findOneByName(strtolower($car->getColour()->getName()));
            $car->setColour($colour);

            $cars->save($car);
        } catch (ValidationException $e) {
            $response = [
                "message" => $e->getMessage(),
                "errors" => $e->getErrors()
            ];

            foreach ($response["errors"] as $index => $error) {
                if ($error["parameter"] === "name") {
                    $response["errors"][$index]["parameter"] = "colour";
                }
            }

            return new JsonResponse($response, 400);
        }

        $response = $serializer->serialize($car);
        return JsonResponse::fromJsonString($response);
    }

    /**
     * @Route("/cars/{id}", name="deleteCar", methods={"DELETE"}, requirements={"page"="\d+"})
     */
    public function deleteCar(Request $request, $id, CarRepository $cars, Serializer $serializer): Response
    {
        $car = $cars->find($id);
        if ($car === null) {
            $response = [
                "message" => "The car does not exist."
            ];
            return new JsonResponse($response, 404);
        }
        $response = $serializer->serialize($car);
        $cars->delete($car);
        return JsonResponse::fromJsonString($response);
    }
}
