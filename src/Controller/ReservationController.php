<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ReservationController extends AbstractController
{
    #[Route(path: '/calendrier', name: 'app_reservation_calendrier')]
    public function calendar(): Response
    {
        return $this->render('reservation/calendrier.html.twig');
    }
    #[Route('/reservation', name: 'app_reservation')]
    #[isGranted('ROLE_USER')]
    public function create(Request $request,EntityManagerInterface $entityManager): Response
    {

        $user = $this->getUser(); //recuper le user connecter

        $Reservation = new Reservation();

        //associer l utilisateur connecté a la reservation
        $Reservation->setUser($user);

        // Créer le formulaire avec l'option is_user_connected
       $form = $this->createForm(ReservationType::class, $Reservation, [

      ]);



        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

        }


        $data = $form->getData();

        if ($data->getDatefin() <= $data->getDateCreation()) {
            $form->get('datefin')->addError(new FormError( message: 'Date de fin invalide'));

        } else {

            $entityManager->persist($Reservation);
            $entityManager->flush();

            $this->addFlash('success', 'Votre réservation a bien été enregistrée.');
            return $this->redirectToRoute('app_mesreservation');

        }



          return $this->render('reservation/index.html.twig', [
            'ReservationType' => $form->createView(),
        ]);
    }
}
