<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @param ManagerRegistry $registry
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Book::class);
        $this->entityManager = $entityManager;
    }

    /**
     * @param int $authorId
     * @return array
     */
    public function getAll(int $authorId): array
    {
        return parent::findBy(
            ['author_id' => $authorId],
            ['year' => 'ASC']
        );
    }

    /**
     * @param Book $book
     * @param int $id
     * @return object
     */
    public function setCreate(Book $book, int $id): object
    {
        $book->setAuthorId($id);
        $this->entityManager->persist($book);
        $this->entityManager->flush();

        return $book;
    }

    /**
     * @param Book $book
     * @return object
     */
    public function setUpdate(Book $book): object
    {
        $this->entityManager->flush();

        return $book;
    }

    /**
     * @param Book $book
     */
    public function setDeleteBook(Book $book)
    {
        $this->entityManager->remove($book);
        $this->entityManager->flush();
    }

    /**
     * @param int $bookId
     * @return object
     */
    public function getOneBook(int $bookId): object
    {
        return parent::find($bookId);
    }
}
