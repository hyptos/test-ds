<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class MovieController extends AbstractFOSRestController
{
    /**
     * Creates a movie resource.
     *
     * @Rest\Put("/movie")
     *
     * @return JsonResponse
     **/
    public function put(Request $request, EntityManagerInterface $entityManager)
    {
        $strTitle = $request->get('title');
        $strUrlPoster = $request->get('url_poster');

        if (empty($strTitle)) {
            return new JsonResponse('field title is empty', Response::HTTP_BAD_REQUEST);
        }
        if (empty($strUrlPoster)) {
            return new JsonResponse('field url_poster is empty', Response::HTTP_BAD_REQUEST);
        }

        $objMovie = new Movie();
        $objMovie->setTitle($strTitle);
        $objMovie->setUrlPoster($strUrlPoster);

        $entityManager->persist($objMovie);
        $entityManager->flush();

        return new JsonResponse($objMovie, Response::HTTP_CREATED);
    }

    /**
     * Get a movie resource.
     *
     * @Rest\Get("/movie/{idMovie}")
     *
     * @param Request $request
     *
     * @return JsonResponse
     **/
    public function getMovie(int $idMovie, MovieRepository $movieRepository)
    {
        // movie exist
        $objMovieFound = $movieRepository->find($idMovie);
        if (null === $objMovieFound) {
            throw new HttpException(404, 'Movie not found.');
        }

        return new JsonResponse($objMovieFound, Response::HTTP_OK);
    }
}
