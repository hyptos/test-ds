<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\User;
use App\Repository\MovieRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserMovieController extends AbstractFOSRestController
{
    /**
     * Add a movie resource.
     *
     * @Rest\Put("/user/{idUser}/movie/{idMovie}")
     *
     * @param Request $request
     *
     * @return View
     **/
    public function put(int $idUser, int $idMovie, MovieRepository $movieRepository, UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        // user exist
        $objUser = $userRepository->find($idUser);
        if (null === $objUser) {
            throw new HttpException(Response::HTTP_NOT_FOUND, 'User not found.');
        }

        // movie exist
        $objMovieFound = $movieRepository->find($idMovie);
        if (null === $objMovieFound) {
            throw new HttpException(Response::HTTP_NOT_FOUND, 'Movie not found.');
        }

        // user_movie exist
        $bHasMovie = $objUser->hasMovie($objMovieFound);
        if ($bHasMovie) {
            throw new HttpException(Response::HTTP_NO_CONTENT, 'Movie already exist.');
        }

        // user_movie added
        $objUser->addMovie($objMovieFound);
        $entityManager->persist($objUser);
        $entityManager->flush();

        return new JsonResponse($objMovieFound, Response::HTTP_CREATED);
    }

    /**
     * Delete a movie resource.
     *
     * @Rest\Delete("/user/{idUser}/movie/{idMovie}")
     *
     * @param Request $request
     *
     * @return View
     **/
    public function delete(int $idUser, int $idMovie, MovieRepository $movieRepository, UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        // user exist
        $objUser = $userRepository->find($idUser);
        if (null === $objUser) {
            throw new HttpException(Response::HTTP_NOT_FOUND, 'User not found.');
        }

        // movie exist
        $objMovie = $movieRepository->find($idMovie);
        if (null === $objMovie) {
            throw new HttpException(Response::HTTP_NOT_FOUND, 'Movie not found.');
        }

        // user_movie exist
        $bHasMovie = $objUser->hasMovie($objMovie);
        if ($bHasMovie) {
            $objUser->removeMovie($objMovie);
        }

        $entityManager->persist($objUser);
        $entityManager->flush();

        return new JsonResponse($objMovie, Response::HTTP_OK);
    }

    /**
     * Get all movies from a user resource.
     *
     * @Rest\Get("/user/{userId}/movies")
     *
     * @param Request $request
     *
     * @return View
     **/
    public function getMovies(int $userId, UserRepository $userRepository)
    {
        // user exist
        $intIdUser = $userId;
        $objUser = $userRepository->find($intIdUser);
        if (null === $objUser) {
            throw new HttpException(Response::HTTP_NOT_FOUND, 'User not found.');
        }

        $colMovies = $objUser->getMovies()->toArray();

        return new Response(json_encode($colMovies), Response::HTTP_OK);
    }

    /**
     * Get all users from a movie resource.
     *
     * @Rest\Get("/movie/{movieId}/users")
     *
     * @param Request $request
     *
     * @return View
     **/
    public function getUsers(int $movieId, MovieRepository $movieRepository)
    {
        // movie exist
        $intIdMovie = $movieId;
        $objMovie = $movieRepository->find($intIdMovie);
        if (null === $objMovie) {
            throw new HttpException(Response::HTTP_NOT_FOUND, 'Movie not found.');
        }

        $colUsers = $objMovie->getUser();
        $arrUsers = [];
        foreach ($colUsers as $objUser) {
            $arrUsers[] = $objUser->toArray();
        }

        return new Response(json_encode($arrUsers), Response::HTTP_OK);
    }
}
