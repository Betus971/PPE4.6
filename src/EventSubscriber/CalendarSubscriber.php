<?php

namespace App\EventSubscriber;

// ...
use App\Repository\ReservationRepository;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\SetDataEvent;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CalendarSubscriber implements EventSubscriberInterface
{
    public function __construct(
          private readonly ReservationRepository $reservationRepository,

        private readonly UrlGeneratorInterface $router
    ) {}

    public static function getSubscribedEvents()
    {
        return [
            SetDataEvent::class => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(SetDataEvent $setDataEvent)
    {
        $start = $setDataEvent->getStart();
        $end = $setDataEvent->getEnd();
        $filters = $setDataEvent->getFilters();

        // Modify the query to fit to your entity and needs
        // Change booking.beginAt by your start date property
        $reservations = $this->reservationRepository
            ->createQueryBuilder('reservation')
            ->where('reservation.dateCreation BETWEEN :start and :end OR reservation.datefin BETWEEN :start and :end')
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult()
        ;

        foreach ($reservations as $reservation) {
            // this create the events with your data (here booking data) to fill calendar

            $reservationEvent = new Event(
                $reservation->getTerrain(),

                $reservation->getDateCreation(),
                $reservation->getDatefin() // If the end date is null or not defined, a all day event is created.
            );

            /*
             * Add custom options to events
             *
             * For more information see: https://fullcalendar.io/docs/event-object
             */
            $reservationEvent->setOptions([
                'backgroundColor' => 'rgb(0, 191, 255)',
                'borderColor' => 'red',
            ]);

            $reservationEvent->addOption(
                'url',
                $this->router->generate('app_mesreservation_show', [
                    'id' => $reservation->getId(),
                ])
            );


            // finally, add the event to the CalendarEvent to fill the calendar
            $setDataEvent->addEvent($reservationEvent);
        }
    }
}