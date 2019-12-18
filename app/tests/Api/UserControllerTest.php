<?php

declare(strict_types=1);

namespace App\Tests\Controller\Api;

use PHPUnit\Framework\TestCase;

final class UserControllerTest extends TestCase
{
    public function testCreateUser()
    {

    	$client = new \GuzzleHttp\Client([
            'debug'     =>  false
        ]);

        $data = array(
            'pseudo' => 'foo',
            'date_naissance' => 5,
            'email' => 'foo@bar.com'
        );
        $response = $client->put('web/v1/user', ['form_params' => $data, 'verify' => false]);


        $this->assertEquals(201, $response->getStatusCode());
        
    }
}
