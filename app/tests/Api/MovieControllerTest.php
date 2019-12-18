<?php

declare(strict_types=1);

namespace App\Tests\Controller\Api;

use PHPUnit\Framework\TestCase;

final class MovieControllerTest extends TestCase
{
    public function testCreateMovie()
    {

    	$client = new \GuzzleHttp\Client([
            'debug'     =>  false
        ]);

        $data = array(
            'title' => 'super_title',
            'url_poster' => 'super_poster',
        );
        $response = $client->put('web/v1/movie', ['form_params' => $data, 'verify' => false]);


        $this->assertEquals(201, $response->getStatusCode());
        
    }
}
