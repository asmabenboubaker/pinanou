<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Repository\BlogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
class ApiBlogController extends AbstractController
{

/**
     * @Route("/api/blog/", name="api_blog" , methods={"GET"})
     */

    public function index(BlogRepository $repo)
    {
        return $this->json($repo->findAll(),200,[],['groups'=>'blog']);
    }

    /**
     * @Route("/api/blog/{id}", name="api_blog_supp",methods={"POST"}, requirements={"id"="\d+"})
     */

    public function deleteAction(Blog $id)
    {
        $em=$this->getDoctrine()->getManager();

        $em->remove($id);
        $em->flush();
        return new JsonResponse(['msg' => 'event supprimer'],200);
    }
    /**
 * @Route("/api/blog/ajouter/", name="api_blog_add",methods={"GET"})
 */
public function add(Request $request)
{
    
    $data = new Blog();
    
    $data->setNom((String)$request->query->get('nom'));
   // $data->setDate((String)$request->query->get('date'));
    $data->setImage((String)$request->query->get('image'));
    $data->setDescri((String)$request->query->get('descri'));


    $em = $this->getDoctrine()->getManager();
    $em->persist($data);
    $em->flush();
    return new JsonResponse(['msg' => 'event ajouté'],200);
}

/**
     * @Route("/api/blog/modifier/{id}/", name="edit",methods={"GET"})
     */
    public function edit(Request $request,$id,BlogRepository $repository)
    {
         
        $data =$repository->find($id);
 
        $data->setNom((String)$request->query->get('nom'));
        
        $data->setImage((String)$request->query->get('image'));
        $data->setDescri((String)$request->query->get('descri'));


        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        return new JsonResponse(['msg' => 'event moddifié'],200);
    }
}