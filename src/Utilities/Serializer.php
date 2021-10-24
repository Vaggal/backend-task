<?php

namespace App\Utilities;

use App\Entity\Car;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class Serializer
{
    /**
    * @var SerializerInterface
    */
    public $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * Serializes an instance in the appropriate format.
     *
     * @param string $format
     * @return string
     */
    public function serialize($entity, string $format = 'json'): string
    {
        if ($entity instanceof Car || (isset($entity[0]) && $entity[0] instanceof Car)) {
            $jsonMessage = $this->serializer->serialize($entity, $format, ['groups' => 'car']);
        } else {
            $jsonMessage = $this->serializer->serialize($entity, $format, ['groups' => 'colour']);
        }
        return $jsonMessage;
    }

    /**
     * Deserializes data into the given type.
     *
     * @param string $carData
     * @param string $type
     * @param array|null $constructorArgs
     * @param string $format
     */
    public function deserialize(string $carData, string $type, array $constructorArgs = null, string $format = 'json')
    {
        if ($type === Car::class) {
            return $this->serializer->deserialize($carData, $type, $format, ['groups' => 'car']);
        } else {
            return $this->serializer->deserialize($carData, $type, $format, ['groups' => 'colour']);
        }
    }
}
