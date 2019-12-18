<?php

declare(strict_types=1);

namespace App\Tests\Controller\Api;

use PHPUnit\Framework\TestCase;

final class UserMovieControllerTest extends TestCase
{
    public function testAddMovieToUser()
    {

    	$client = new \GuzzleHttp\Client([
            'debug'     =>  false
        ]);

        // New movie for this user
        $response = $client->put('web/v1/user/1/movie/1', ['verify' => false]);
        $this->assertEquals(201, $response->getStatusCode());

        // movie not found
        $response = $client->put('web/v1/user/1/movie/11111', ['verify' => false, 'http_errors' => false]);
        $this->assertEquals(404, $response->getStatusCode());


        // user not found
        $response = $client->put('web/v1/user/11111/movie/1', ['verify' => false, 'http_errors' => false]);
        $this->assertEquals(404, $response->getStatusCode());


        // Movie already exist for this user
        $response = $client->put('web/v1/user/1/movie/1', ['verify' => false]);
        $this->assertEquals(204, $response->getStatusCode());
        
    }

    public function testDeleteMovieToUser()
    {

        $client = new \GuzzleHttp\Client([
            'debug'     =>  false
        ]);

        // Delete this movie for this user
        $response = $client->delete('web/v1/user/1/movie/1', ['verify' => false]);
        $this->assertEquals(200, $response->getStatusCode());

        // movie not found
        $response = $client->delete('web/v1/user/1/movie/11111', ['verify' => false, 'http_errors' => false]);
        $this->assertEquals(404, $response->getStatusCode());


        // user not found
        $response = $client->delete('web/v1/user/11111/movie/1', ['verify' => false, 'http_errors' => false]);
        $this->assertEquals(404, $response->getStatusCode());


        // Already Deleted
        $response = $client->delete('web/v1/user/1/movie/1', ['verify' => false]);
        $this->assertEquals(200, $response->getStatusCode());
        
    }

    public function testListeMoviesToUser()
    {

        $client = new \GuzzleHttp\Client([
            'debug'     =>  false
        ]);

        // list all movies for this user
        $response = $client->get('web/v1/user/1/movies', ['verify' => false]);
        $this->assertEquals(200, $response->getStatusCode());

        // user not found
        $response = $client->get('web/v1/user/11111/movies', ['verify' => false, 'http_errors' => false]);
        $this->assertEquals(404, $response->getStatusCode());

        
    }

    public function testListeUsersToMovie()
    {

        $client = new \GuzzleHttp\Client([
            'debug'     =>  false
        ]);

        // list all users for this movie
        $response = $client->get('web/v1/movie/1/users', ['verify' => false]);
        $this->assertEquals(200, $response->getStatusCode());

        // movie not found
        $response = $client->get('web/v1/movie/11111/users', ['verify' => false, 'http_errors' => false]);
        $this->assertEquals(404, $response->getStatusCode());

        
    }
}
