<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RankController extends AbstractFOSRestController
{
    /**
     * Get the ranking of a movie resource.
     *
     * @Rest\Get("/rank/movie")
     *
     * @param Request $request
     *
     * @return View
     **/
    public function getMovie(MovieRepository $movieRepository)
    {
        $objResult = $movieRepository->getBestMovie();

        return new JsonResponse($objResult, Response::HTTP_OK);
    }
}
