<?php

namespace App\Controller;

use App\Repository\ReservationRepository;
use App\Repository\TerrainRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

final class StatistiqueController extends AbstractController
{
    #[Route('/statistique', name: 'app_statistique')]
    public function index( ReservationRepository $reservationRepository , TerrainRepository $terrainRepository,ChartBuilderInterface $chartBuilder): Response
    {
        $reservations = $reservationRepository->findAll();
        $terrains = $terrainRepository->findAll();

        $data= [];

        foreach ($reservations as $reservation) {
            $data[]= $reservation->getId();

        }
        $info = [];
        $labels = [];

        foreach ($terrains as $terrain) {
            $info []= $terrain->getId();
            $labels[]=$terrain->getNomTerrain();
        }



        $chart = $chartBuilder->createChart(Chart::TYPE_BAR);
        $chart->setData([
            'labels' =>['January', 'February', 'March', 'April', 'May', 'June', 'July','august','september','october','november','december'],
            'datasets' => [
                [
                    'label' => 'Reservations',
                    'backgroundColor' => 'rgb(200, 99, 132, .4)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => $data,
                    'tension' => 0.4,
                ],
        ],
        ]);
        $chartTerrain = $chartBuilder->createChart(Chart::TYPE_PIE);
        $chartTerrain->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Terrain reservations',
                    'backgroundColor' => [
                        'rgb(54, 162, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(255, 159, 64)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'],
                    'data' => $info,
                    'tension' => 0.4,
                ],
            ],
        ]);

        return $this->render('statistique/index.html.twig', [
            'chart' => $chart,
            'chartTerrain' => $chartTerrain,
        ]);
    }
}
