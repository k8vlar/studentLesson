<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="app_search")
     */
    public function index(Request $request, ArticleRepository $articleRepository): Response
    {
        $search = $request ->query->get('search');
        $artcles = $articleRepository->findBySearch($search);
        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
            'articles' => $artcles
        ]);
    }
}