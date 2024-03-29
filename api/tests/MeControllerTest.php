<?php

namespace App\Tests;

class MeControllerTest extends ParentController
{
    public function testLoggedIn(): void
    {
        $client = $this->getAuthorizedClient();
        $client->request('GET', '/api/me');
        $this->assertResponseIsSuccessful();
    }
}
