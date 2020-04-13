<?php

declare(strict_types=1);

namespace App\Infrastructure\Infrastructure\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class MysqlRepository
{
    public function register($model): void
    {
        $this->entityManager->persist($model);
        $this->save();
    }

    public function save(): void
    {
        $this->entityManager->flush();
    }

    protected function oneOrException(\Doctrine\ORM\QueryBuilder $queryBuilder)
    {
        $model = $queryBuilder
            ->getQuery()
            ->getOneOrNullResult();

        if (null === $model)
        {
            throw new NotFoundHttpException();
        }

        return $model;
    }

    private function setRepository(string $model): void
    {
        /** @var EntityRepository $objectRepository */
        $objectRepository = $this->entityManager->getRepository($model);
        $this->repository = $objectRepository;
    }

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->setRepository($this->class);
    }

    protected string $class;

    protected EntityRepository $repository;

    protected EntityManagerInterface $entityManager;
}