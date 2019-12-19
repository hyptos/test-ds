<?php

declare(strict_types=1);

namespace App\Tests\Controller\Api;

use PHPUnit\Framework\TestCase;

final class RankControllerTest extends TestCase
{
    public function testGetBestMovie()
    {

    	$client = new \GuzzleHttp\Client([
            'debug'     =>  false
        ]);

        $response = $client->get('web/rank/movie', ['verify' => false]);


        $this->assertEquals(200, $response->getStatusCode());
        
    }
}
