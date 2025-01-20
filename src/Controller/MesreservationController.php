<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Terrain;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MesreservationController extends AbstractController
{
    #[Route('/mesreservation', name: 'app_mesreservation')]
    public function index( EntityManagerInterface $entityManager): Response
    {
             $User = $this->getUser();

             if(!$User){
                 throw $this->CreateAccessDeniedException( 'vous devez vous connecter pour accéder à vos reservations');
             }

             $reservation = $entityManager->getRepository(Reservation::class)->findby(['User'=>$User]) ;


             return $this->render('mesreservation/index.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[Route('/mesreservation/{id}/delete', name: 'app_reservation_delete', methods: ['POST'])]
    public function deleteReservation(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isCsrfTokenValid('delete_reservation'
            . $reservation->getId(), $request->request->get('_token'))) {
            throw new AccessDeniedException('Invalid CSRF token.');
        }

        $entityManager->remove($reservation);
        $entityManager->flush();

        return $this->redirectToRoute('app_mesreservation'); // Rediriger vers la liste des réservations
    }


    #[Route('/mesreservation/{id}/edit', name: 'app_reservation_edit', methods: ['GET', 'POST'])]
    public function editReservation(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        // Vérifier que l'utilisateur est bien le propriétaire de la réservation
        if ($reservation->getUser() !== $this->getUser()) {
            throw new AccessDeniedException('Vous ne pouvez pas modifier cette réservation.');
        }

        // Créer le formulaire de modification
        $form = $this->createFormBuilder($reservation)
            ->add('dateCreation', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date de création'
            ])
            ->add('datefin', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date de fin'
            ])
            ->add('Terrain', EntityType::class, [
                'class' => Terrain::class,
//                'class'=> Categorie::class,
                'choice_label' => 'NomTerrain',

            ])
            ->getForm();

        // Traitement du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_mesreservation');  // Rediriger vers la liste des réservations
        }

        return $this->render('mesreservation/edit.html.twig', [
            'form' => $form->createView(),
            'reservation' => $reservation
        ]);


    }

}
