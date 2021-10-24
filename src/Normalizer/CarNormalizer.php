<?php
namespace App\Normalizer;

use DateTime;
use App\Entity\Car;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;

class CarNormalizer implements ContextAwareNormalizerInterface, ContextAwareDenormalizerInterface
{
    private $router;
    private $normalizer;

    public function __construct(UrlGeneratorInterface $router, ObjectNormalizer $normalizer)
    {
        $this->router = $router;
        $this->normalizer = $normalizer;
    }

    public function normalize($car, string $format = null, array $context = [])
    {
        $data = $this->normalizer->normalize($car, $format, $context);

        $data["build_date"] = $car->getBuildDate()->format("Y-m-d");
        $data['colour'] = $data['colour']['name'];

        return $data;
    }

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        $data['colour'] = ['name'=>$data['colour']];
        $car = $this->normalizer->denormalize($data, $type, $format, $context);
        return $car;
    }

    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Car;
    }

    public function supportsDenormalization($data, string $type, string $format = null, array $context = [])
    {
        return $type === Car::class;
    }
}
