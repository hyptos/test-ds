<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Movie;

class MovieController extends Controller
{
    /**
     * Matches /movie/
     *
     * @param Request $request
     *
     * @return Response
     */
    public function put(Request $request)
    {

    	$strTitle = $request->get('title');
    	$strUrlPoster = $request->get('url_poster');

    	if(empty($strTitle)) {
    		return new JsonResponse('field title is empty', Response::HTTP_BAD_REQUEST );
    	}
    	if(empty($strUrlPoster)) {
    		return new JsonResponse('field url_poster is empty', Response::HTTP_BAD_REQUEST );
    	}

        $objMovie = new Movie();
        $objMovie->setTitle($strTitle);
        $objMovie->setUrlPoster($strUrlPoster);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($objMovie);
        $entityManager->flush();

		return new JsonResponse($objMovie, Response::HTTP_CREATED);
    }

}
