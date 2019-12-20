<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserController extends AbstractFOSRestController
{
    /**
     * Create a user resource.
     *
     * @Rest\Put("/user")
     *
     * @return JsonResponse
     **/
    public function put(Request $request, EntityManagerInterface $entityManager)
    {
        $strPseudo = $request->get('pseudo');
        $strDateNaissance = $request->get('date_naissance');
        $strEmail = $request->get('email');

        if (empty($strPseudo)) {
            throw new HttpException(Response::HTTP_BAD_REQUEST, 'field pseudo is empty.');
        }
        if (empty($strDateNaissance)) {
            throw new HttpException(Response::HTTP_BAD_REQUEST, 'field date_naissance is empty.');
        }
        if (empty($strEmail) && false === filter_var($strEmail, FILTER_VALIDATE_EMAIL)) {
            throw new HttpException(Response::HTTP_BAD_REQUEST, 'field email is empty.');
        }

        $objUser = new User();
        $objUser->setPseudo($strPseudo);
        $objUser->setDateInserted(new \Datetime());

        $objDateNaissance = new \Datetime();
        $objDateNaissance->setTimestamp((int) $strDateNaissance);
        $objUser->setDateNaissance($objDateNaissance);
        $objUser->setEmail($strEmail);

        $entityManager->persist($objUser);
        $entityManager->flush();

        return new JsonResponse($objUser, Response::HTTP_CREATED);
    }
}
