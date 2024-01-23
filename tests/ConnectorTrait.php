<?php
/*
 * User: Henny Krijnen
 * Date: 08-03-22 11:49
 * Copyright (c) eWarehousing Solutions
 */

namespace MiddlewareConnector\Tests;

use MiddlewareConnector\MiddlewareConnector;
use MiddlewareConnector\Requests\Auth\PostAuthTokenRequest;
use MiddlewareConnector\Requests\Auth\PostRefreshTokenRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

trait ConnectorTrait
{
    public function getMockClient(array $responses): MockClient
    {
        $mockClient = new MockClient([
            PostRefreshTokenRequest::class => new MockResponse(['token' => 'MY_TEST_TOKEN', 'refresh_token' => ''], 200),
            PostAuthTokenRequest::class => new MockResponse(['token' => 'MY_TEST_TOKEN', 'refresh_token' => ''], 200),
        ]);
        $mockClient->addResponses($responses);
        return $mockClient;
    }

    public function getConnector(?MockClient $mockClient = null)
    {
        return MiddlewareConnector::create(
            'username',
            'password',
            'wmsCode',
            'CustomerCode',
            MiddlewareConnector::BASE_URL_EU_DEV,
        )->withMockClient($mockClient);
    }
}