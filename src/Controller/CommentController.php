<?php

namespace App\Controller;

use DateTimeImmutable;
use App\Entity\Article;
use App\Entity\Comment;
use App\Form\Comment1Type;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/article/{id}/comment")
 */
class CommentController extends AbstractController
{
   
    /**
     * @Route("/new", name="app_comment_new", methods={"GET", "POST"})
     */
    public function new(Request $request, Article $article, CommentRepository $commentRepository): Response
    {
        $comment = new Comment();
        $comment->setCreatedAt(new DateTimeImmutable());
        // recuperer la date de creation par defaut
        $comment->setUser( $this->getUser());
        // recuperer  l'utilisateur connecté par defaut
        $comment->setArticle( $article);
        // recuperer l'id de l'article par defaut lors de la création  d'un commentaire 
        $form = $this->createForm(Comment1Type::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentRepository->add($comment, true);

            return $this->redirectToRoute('app_article_show', [
                'id'=>$article->getId()
                // entre crochet permet de rediriger vers la page show de l'id en question
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comment/new.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }
}
