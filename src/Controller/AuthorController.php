<?php


namespace App\Controller;


use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends BaseController
{
    /**
     * @var $AuthorRepository
     */
    private $AuthorRepository;

    public function __construct(AuthorRepository $AuthorRepository)
    {
        $this->AuthorRepository = $AuthorRepository;
    }

    /**
     * @Route("/", name="authors")
     * @return Response
     */
    public function showAuthors()
    {
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Authors';
        $forRender['authors'] = $this->AuthorRepository->getAll();        //список авторов
        return $this->render('author/index.html.twig', $forRender);
    }

    /**
     * @Route("/author/create", name="author_create")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function createAuthor(Request $request)
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);                                 //получаем данные из формы

        if (($form->isSubmitted()) && ($form->isValid()))               //проверяем данные из формы
        {
            $this->AuthorRepository->setCreate($author);
            $this->addFlash('success', 'Автор добавлен!');
            return $this->redirectToRoute('authors');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Author create';
        $forRender['form'] = $form->createView();                       //для создания вида формы
        return $this->render('author/form.html.twig', $forRender);
    }

    /**
     * @Route("/author/update/{id}", name="author_update")
     * @param int $id
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function updateAuthor(int $id, Request $request)
    {
        $author = $this->AuthorRepository->getOneAuthor($id);           //получаем данные автора по id
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if (($form->isSubmitted()) && ($form->isValid()))
        {
            $this->AuthorRepository->setUpdate($author);
            $this->addFlash('success', 'Данные изменены!');
            return $this->redirectToRoute('authors');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Author update';
        $forRender['form'] = $form->createView();
        return $this->render('author/form.html.twig', $forRender);
    }




}