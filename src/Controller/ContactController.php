<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use App\Entity\Contact;
class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $req): Response
    {
    	$contact=new Contact();
    	$form = $this->createForm(ContactType::class,$contact, [
    		'action' => $this->generateUrl('contact'),
    		'method' => 'POST',
    	]);
    	        $form->handleRequest($req);
    	        if ($form->isSubmitted() && $form->isValid()){
    	        	$contact=$form->getData();
    	        	 $em= $this->getDoctrine()->getManager();
    	        	  $em->persist($contact);
    	        	  $em->flush();
    	        	  $this->addFlash('success', 'votre msg a envoyer avec success');
    	        	  return $this->redirectToRoute('contact');
    	        	}

        return $this->render('contact/index.html.twig', [
            'form'=>$form->createView() 
        ]);
    }
}
