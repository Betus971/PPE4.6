<?php

namespace App\Controller;

use App\Repository\ReservationRepository;
use App\Repository\TerrainRepository;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use EasyCorp\Bundle\EasyAdminBundle\Field\Configurator\UrlConfigurator;
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



        $chart = $chartBuilder->createChart(Chart::TYPE_POLAR_AREA);
        $chart->setData([
            'labels' =>['January', 'February', 'March', 'April', 'May', 'June', 'July','august','september','october','november','december'],
            'datasets' => [
                [
                    'label' => 'Reservations',
                    'backgroundColor' =>      ['rgba(255, 99, 132, 0.6)',  // Rouge rosé
                    'rgba(54, 162, 235, 0.6)',  // Bleu
                    'rgba(255, 206, 86, 0.6)',  // Jaune
                    'rgba(75, 192, 192, 0.6)',  // Vert d'eau
                    'rgba(153, 102, 255, 0.6)', // Violet
                    'rgba(255, 159, 64, 0.6)',  // Orange
                    'rgba(233, 30, 99, 0.6)',   // Rose foncé
                    'rgba(0, 188, 212, 0.6)',   // Bleu turquoise
                    'rgba(205, 220, 57, 0.6)',  // Vert citron
                    'rgba(96, 125, 139, 0.6)',  // Gris bleuté
                    'rgba(255, 87, 34, 0.6)',   // Orange foncé
                    'rgba(158, 158, 158, 0.6)'], // Gris neutre

                    'borderColor' =>[ 'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 206, 86)',
                'rgb(75, 192, 192)',
                'rgb(153, 102, 255)',
                'rgb(255, 159, 64)',
                'rgb(233, 30, 99)',
                'rgb(0, 188, 212)',
                'rgb(205, 220, 57)',
                'rgb(96, 125, 139)',
                'rgb(255, 87, 34)',
                'rgb(158, 158, 158)'],
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
