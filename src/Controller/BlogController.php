<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Blog;
use App\Form\BlogType;
use App\Repository\BlogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use App\Form\SearchForm;
 

/**
 * @Route("/blog")
 */
class BlogController extends AbstractController
{
    /**
     * @Route("/", name="app_blog_index", methods={"GET"})
     */
    public function index(BlogRepository $blogRepository,Request $request, PaginatorInterface $paginator): Response
    {
        $data=new SearchData();
        $form=$this->createForm(SearchForm::class,$data);
        $form->handleRequest($request);
        $tableusers=$blogRepository->findAll($data);
        
        $marques = $paginator->paginate(
            $tableusers, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            4 // Nombre de résultats par page
        );
        return $this->render('blog/index.html.twig', [
            'blogs' => $marques,
        ]);
    }
    
    /**
     * @Route("/fil", name="blog")
     */
    public function indexf(BlogRepository $blogRepository,Request $request, PaginatorInterface $paginator): Response
    {
        $data=new SearchData();
        $form=$this->createForm(SearchForm::class,$data);
        $form->handleRequest($request);
        $tableusers=$blogRepository->findSearch($data);
        
        $marques = $paginator->paginate(
            $tableusers, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            4 // Nombre de résultats par page
        );
        return $this->render('blog/filblog.html.twig', [
            'marques'=>$marques,
             'form'=> $form->createView()
        ]);
    }
    

    /**
     * @Route("/new", name="app_blog_new", methods={"GET", "POST"})
     */
    public function new(Request $request, BlogRepository $blogRepository): Response
    {
        
        $blog = new Blog();
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move(
                        'back\images',
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $blog->setImage($newFilename);
            }
            $blogRepository->add($blog);
            return $this->redirectToRoute('app_blog_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('blog/new.html.twig', [
            
            'blog' => $blog,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/home", name="home", methods={"GET", "POST"})
     */
    public function newhome(Request $request, BlogRepository $blogRepository,PaginatorInterface $paginator): Response
    {
        $data=new SearchData();
        $form=$this->createForm(SearchForm::class,$data);
        $form->handleRequest($request);
        $tableusers=$blogRepository->findAll($data);
       // dd($tableusers);
        $marques = $paginator->paginate(
            $tableusers, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            4 // Nombre de résultats par page
        );
        $blog = new Blog();
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move(
                        'back\images',
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $blog->setImage($newFilename);
            }
            $blogRepository->add($blog);
            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('home.html.twig', [
            'marques'=>$marques,
            'blog' => $blog,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_blog_show", methods={"GET"})
     */
    public function show(Blog $blog): Response
    {
        return $this->render('blog/show.html.twig', [
            'blog' => $blog,
        ]);
    }
    /**
     * @Route("ss/{id}", name="showhome", methods={"GET"})
     */
    public function showhome(Blog $blog): Response
    {
        return $this->render('front/show.html.twig', [
            'blog' => $blog,
        ]);
    }
    

    /**
     * @Route("/{id}/edit", name="app_blog_edit")
     */
    public function edit(Request $request, Blog $blog, BlogRepository $blogRepository): Response
    {
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move(
                        'back\images',
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $blog->setImage($newFilename);
            }
            $blogRepository->add($blog);
            return $this->redirectToRoute('app_blog_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('blog/edit.html.twig', [
            'blog' => $blog,
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("edit/home/{id}", name="edithome")
     */
    public function edithome(Request $request, Blog $blog, BlogRepository $blogRepository): Response
    {
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move(
                        'back\images',
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $blog->setImage($newFilename);
            }
            $blogRepository->add($blog);
            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('front/edit.html.twig', [
            'blog' => $blog,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("supp/{id}",name="delete")
     */
    public function supprimerblogc($id,EntityManagerInterface $em ,BlogRepository $repository){
        $marque=$repository->find($id);
        $em->remove($marque);
        $em->flush();

        return $this->redirectToRoute('app_blog_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("supphome/{id}",name="deletehome")
     */
    public function supprimerblog($id,EntityManagerInterface $em ,BlogRepository $repository){
        $marque=$repository->find($id);
        $em->remove($marque);
        $em->flush();

        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }
}
