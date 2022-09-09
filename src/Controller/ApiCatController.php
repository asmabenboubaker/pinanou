<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
class ApiCatController extends AbstractController
{
/**
     * @Route("/api/cat/", name="api_blog" , methods={"GET"})
     */

    public function index(CategorieRepository $repo)
    {
        return $this->json($repo->findAll(),200,[],['groups'=>'blog']);
    }
     /**
 * @Route("/api/cat/ajouter/", name="api_cat_add",methods={"GET"})
 */
public function add(Request $request)
{
    
    $data = new Categorie();
    
    $data->setNom((String)$request->query->get('nom'));
  
     
    $em = $this->getDoctrine()->getManager();
    $em->persist($data);
    $em->flush();
    return new JsonResponse(['msg' => 'cat ajouté'],200);
}

    /**
     * @Route("/api/cat/{id}", name="api_cat_supp",methods={"POST"}, requirements={"id"="\d+"})
     */

    public function deleteAction(Categorie $id)
    {
        $em=$this->getDoctrine()->getManager();

        $em->remove($id);
        $em->flush();
        return new JsonResponse(['msg' => 'cat supprimer'],200);
    }

}
