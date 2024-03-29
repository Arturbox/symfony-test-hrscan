<?php

namespace App\Tests;


class AccountControllerTest extends ParentController
{

    public function testNoAuth(): void
    {
        $client = $this->getNoAuthClient();
        $client->jsonRequest('GET', '/api/currencies');

        $this->assertJsonStringEqualsJsonString($client->getResponse()->getContent(), '{"error":"Access Denied."}');
    }

    public function testCreate(): void
    {
        $data = [
            'currency_id' => 2,
            'amount' => 1000
        ];
        $client = $this->getAuthorizedClient();
        $client->jsonRequest('POST', '/api/accounts', $data);

        $this->assertResponseIsSuccessful();
    }

    public function testAll(): void
    {
        $client = $this->getAuthorizedClient();
        $client->jsonRequest('GET', '/api/accounts');

        $this->assertResponseIsSuccessful();
    }


    public function testUpdate(): void
    {
        $client = $this->getAuthorizedClient();

        $client->jsonRequest('PUT', '/api/accounts/1', [
            'currency_id' => 2,
            'amount' => 2000
        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testDelete(): void
    {
        $client = $this->getAuthorizedClient();

        $client->jsonRequest('DELETE', '/api/accounts/1');

        $this->assertResponseIsSuccessful();
    }

}
