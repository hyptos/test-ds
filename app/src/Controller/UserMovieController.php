<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Entity\Movie;

class UserMovieController extends Controller
{

	/**
     * Matches /user/{id}/movie/{id}
     *
     * @param Request $request
     *
     * @return Response
     */
    public function put(Request $request)
    {
    	// user exist
    	$intIdUser = $request->get('idUser');
        $objUser = $this->getDoctrine()->getRepository(User::class)->find($intIdUser);
        if ($objUser === null) {
            return new JsonResponse('user not found', Response::HTTP_NOT_FOUND );
        }

    	// movie exist
    	$intIdMovie = $request->get('idMovie');
        $objMovieFound = $this->getDoctrine()->getRepository(Movie::class)->find($intIdMovie);
        if ($objMovieFound === null) {
            return new JsonResponse('movie not found', Response::HTTP_NOT_FOUND );
        }


    	// user_movie exist
        $colMovies = $objUser->getMovies();
        $arrIdsMovies = [];
        foreach($colMovies as $objMovie) {
            $arrIdsMovies[] = $objMovie->getId();
        } 
    	if (in_array($intIdMovie, $arrIdsMovies)) {	       
            return new JsonResponse('movie already exist', Response::HTTP_NO_CONTENT);
    	}

    	// user_movie added
    	$objUser->addMovie($objMovieFound);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($objUser);
        $entityManager->flush();
    	

        return new Response($objMovieFound, Response::HTTP_CREATED);
    }

	/**
     * Matches /user/{id}/movie/{id}
     *
     * @param Request $request
     *
     * @return Response
     */
    public function delete(Request $request)
    {

    	// user exist
    	$intIdUser = $request->get('idUser');
        $objUser = $this->getDoctrine()->getRepository(User::class)->find($intIdUser);
        if ($objUser === null) {
            return new JsonResponse('user not found', Response::HTTP_NOT_FOUND );
        }

    	// movie exist
    	$intIdMovie = $request->get('idMovie');
        $objMovie = $this->getDoctrine()->getRepository(Movie::class)->find($intIdMovie);
        if ($objMovie === null) {
            return new JsonResponse('movie not found', Response::HTTP_NOT_FOUND );
        }

    	// user_movie exist
        $colMovies = $objUser->getMovies();
        $arrIdsMovies = [];
        foreach($colMovies as $objMovie) {
            $arrIdsMovies[] = $objMovie->getId();
        } 
        if (in_array($intIdMovie, $arrIdsMovies)) {        
            $objUser->removeMovie($objMovie);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($objUser);
        $entityManager->flush();

        return new Response($objMovie, Response::HTTP_OK);
    }

	/**
     * Matches /user/{id}/movies
     *
     * @param Request $request
     *
     * @return Response
     */
    public function getMovies(Request $request)
    {

    	// user exist
    	$intIdUser = $request->get('idUser');
        $objUser = $this->getDoctrine()->getRepository(User::class)->find($intIdUser);
        if ($objUser === null) {
            return new JsonResponse('user not found', Response::HTTP_NOT_FOUND );
        }

    	$colMovies = $objUser->getMovies()->toArray();
        $colMovies = $objUser->getMovies();
        $arrMovies = [];
        foreach($colMovies as $objMovie) {
            $arrMovies[] = $objMovie->toArray();
        } 

        return new JsonResponse($arrMovies, Response::HTTP_OK);
    }

	/**
     * Matches /movie/{id}/users
     *
     * @param Request $request
     *
     * @return Response
     */
    public function getUsers(Request $request)
    {

    	// movie exist
    	$intIdMovie = $request->get('idMovie');
        $objMovie = $this->getDoctrine()->getRepository(Movie::class)->find($intIdMovie);
        if ($objMovie === null) {
            return new JsonResponse('movie not found', Response::HTTP_NOT_FOUND );
        }
    	

        $colUsers = $objMovie->getUser();
        $arrUsers = [];
        foreach($colUsers as $objUser) {
            $arrUsers[] = $objUser->toArray();
        } 

        return new JsonResponse($arrUsers, Response::HTTP_OK);
    }

}   
