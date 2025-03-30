<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ErrorController extends AbstractController
{
    #[Route('/error', name: 'app_error')]
    public function show(FlattenException $exception): Response
    {
          $statusCode = $exception->getStatusCode();
          if ($statusCode === Response::HTTP_NOT_FOUND) {
              return $this->render('error/404.html.twig');

          }
        return $this->render('error/index.html.twig', [
            'status_code' => $statusCode,
            'message' => $exception->getMessage(),

        ]);
    }
}
