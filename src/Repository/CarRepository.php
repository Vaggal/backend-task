<?php

namespace App\Repository;

use App\Entity\Car;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use App\Exception\ValidationException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Car|null find($id, $lockMode = null, $lockVersion = null)
 * @method Car|null findOneBy(array $criteria, array $orderBy = null)
 * @method Car[]    findAll()
 * @method Car[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarRepository extends ServiceEntityRepository
{
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    public function __construct(ManagerRegistry $registry, ValidatorInterface $validator)
    {
        parent::__construct($registry, Car::class);
        $this->validator = $validator;
    }

    public function delete($car)
    {
        $this->getEntityManager()->remove($car);
        $this->getEntityManager()->flush();
    }

    /**
     * Persists a valid instance of Car entity
     *
     * @param Car $car
     * @return boolean
     * @throws ValidationException If the entity instance is invalid
     * @throws ORMException If persist() fails
     * @throws \Throwable
     */
    public function save(Car $car): bool
    {
        $errors = $this->validator->validate($car);
        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }

        $this->getEntityManager()->persist($car);
        $this->getEntityManager()->flush();
        return true;
    }
}
