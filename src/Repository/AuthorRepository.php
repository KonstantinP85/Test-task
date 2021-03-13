<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Author|null find($id, $lockMode = null, $lockVersion = null)
 * @method Author|null findOneBy(array $criteria, array $orderBy = null)
 * @method Author[]    findAll()
 * @method Author[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Author::class);
        $this->entityManager = $entityManager;
    }
    public function getAll(): array
    {
        return parent::findAll();
    }

    public function setCreate(Author $author): object
    {
        $this->entityManager->persist($author);
        $this->entityManager->flush();
        return $author;
    }

    public function setUpdate(Author $author): object
    {
        $this->entityManager->flush();
        return $author;
    }

    public function getOneAuthor(int $authorId): object
    {
        return parent::find($authorId);
    }


}
