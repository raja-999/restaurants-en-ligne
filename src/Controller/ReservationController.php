<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Reservation;
use App\Form\ReservationType;
use Symfony\Component\Validateur\Constraints\DateTime;
class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'reservation')]
    public function index(Request $req): Response
    {
    	$reservation=new Reservation();
    	$form = $this->createForm(ReservationType::class,$reservation, [
    		'action' => $this->generateUrl('reservation'),
    		'method' => 'POST',
    	]);
    	        $form->handleRequest($req);
    	        if ($form->isSubmitted() && $form->isValid()){
    	        	$reservation=$form->getData();
    	        	$date=new \DateTime();
                    $reservation->setDate($date);
    	        	  $em= $this->getDoctrine()->getManager();
    	        	  $em->persist($reservation);
    	        	  $em->flush();
    	        	  $this->addFlash('success', 'votre reservation a envoyer avec success');
    	        	  return $this->redirectToRoute('reservation');
    	        	}
        return $this->render('reservation/index.html.twig', [
             'form'=>$form->createView() 
        ]);
    }
}
