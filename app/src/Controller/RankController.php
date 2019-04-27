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
use App\Repository\MovieRepository;

class RankController extends Controller
{
	public function getMovie() {

		$objResult = $this->getDoctrine()->getRepository(Movie::class)->getBestMovie();

        return new JsonResponse($objResult, Response::HTTP_OK);
	}
}