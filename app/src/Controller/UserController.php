<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;

class UserController extends Controller
{
    /**
     * Matches /user/
     *
     * @param Request $request
     *
     * @return Response
     */
    public function put(Request $request)
    {

    	$strPseudo = $request->get('pseudo');
    	$strDateNaissance = $request->get('date_naissance');
    	$strEmail = $request->get('email');

    	if(empty($strPseudo)) {
    		return new JsonResponse('field pseudo is empty', Response::HTTP_BAD_REQUEST );
    	}
    	if(empty($strDateNaissance)) {
    		return new JsonResponse('field date_naissance is empty', Response::HTTP_BAD_REQUEST );
    	}
    	if(empty($strEmail) && filter_var($strEmail, FILTER_VALIDATE_EMAIL) === false) {
    		return new JsonResponse('field email is empty', Response::HTTP_BAD_REQUEST );
    	}

        $objUser = new User();
        $objUser->setPseudo($strPseudo);
        $objUser->setDateInserted(new \Datetime());

        $objDateNaissance = new \Datetime();
        $objDateNaissance->setTimestamp((int)$strDateNaissance);
        $objUser->setDateNaissance($objDateNaissance);
        $objUser->setEmail($strEmail);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($objUser);
        $entityManager->flush();

		return new JsonResponse($objUser, Response::HTTP_CREATED);
    }

}
