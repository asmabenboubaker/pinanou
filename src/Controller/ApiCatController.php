<?php

namespace App\Controller;

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
}
