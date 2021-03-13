<?php


namespace App\Controller;


use App\Entity\Author;
use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends BaseController
{
    /**
     * @var $BookRepository
     */
    private $BookRepository;

    public function __construct(BookRepository $BookRepository)
    {
        $this->BookRepository = $BookRepository;
    }

    /**
     * @Route("/author/{id}/books", name="books")
     * @param int $id
     * @return Response
     */
    public function showBooks(int $id)
    {
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Books';
        $forRender['books'] = $this->BookRepository->getAll($id);                                                   //список книг автора
        $forRender['author'] = $this->getDoctrine()->getRepository(Author::class)->getOneAuthor($id);  //данные автора
        return $this->render('book/index.html.twig', $forRender);
    }

    /**
     * @Route("/author/{id}/book/create", name="book_create")
     * @param int $id
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function createBook(int $id, Request $request)
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);                                 //получаем данные из формы

        if (($form->isSubmitted()) && ($form->isValid()))               //проверяем данные из формы
        {
            $this->BookRepository->setCreate($book, $id);
            $this->addFlash('success', 'Книга добавлена!');
            return $this->redirectToRoute('books', array('id' => $id));
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Book create';
        $forRender['form'] = $form->createView();                       //для создания вида формы
        return $this->render('book/form.html.twig', $forRender);
    }

    /**
     * @Route("/author/{id}/book/update/{book_id}", name="book_update")
     * @param int $id
     * @param int $book_id
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function updateBook(int $id, int $book_id, Request $request)
    {
        $book = $this->BookRepository->getOneBook($book_id);
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if (($form->isSubmitted()) && ($form->isValid())) {
            $this->BookRepository->setUpdate($book);;
            $this->addFlash('success', 'Книга обновлена');
            return $this->redirectToRoute('books', array('id' => $id));
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Book update';
        $forRender['form'] = $form->createView();
        return $this->render('book/form.html.twig', $forRender);
    }

    /**
     * @Route("/author/{id}/book/delete/{book_id}", name="book_delete")
     * @param int $id
     * @param int $book_id
     * @param Request $request
     * @return RedirectResponse
     */
    public function deleteBook(int $id, int $book_id, Request $request)
    {
        $book = $this->BookRepository->getOneBook($book_id);
        $this->BookRepository->setDeleteBook($book);
        $this->addFlash('success', 'Книга удалена!');
        return $this->redirectToRoute('books', array('id' => $id));
    }

}