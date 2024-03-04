<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="app_contact")
     */
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class); // Pour que le formulaire soit créé, mais pas encore affiché

        $form->handleRequest($request);
      
        if ($form->isSubmitted() && $form->isValid()) { 
           $adressemail= $form->get('email')->getData();
           // Envoi du mail
           $subject= $form->get('subject')->getData( );
           // envoi du sujet
           $content= $form->get('content') ->getData();
           //envoi du contenu du mail.
           $email = (new Email())
            ->from($adressemail)
            ->to('admin@admin.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($subject)
            ->text($content);
            $mailer->send($email);
            return $this->redirectToRoute('app_success');
        }
        
        return $this->renderForm('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'form' => $form
            //pour rendre un formulaire en twig , soit renderForm, soit render mais avec $formCreatedView
        ]);
    }
        /**
     * @Route("/contact/success", name="app_success")
     */
    public function success(): Response
    {
        return $this->render('success/index.html.twig', [
            'controller_name' => 'SuccessController',
        ]);
    }
}
