<?php
/*
 * User: Henny Krijnen
 * Date: 08-03-22 11:49
 * Copyright (c) eWarehousing Solutions
 */

namespace MiddlewareConnector\Tests;

use MiddlewareConnector\Exceptions\AuthenticationException;
use MiddlewareConnector\MiddlewareAuthenticator;
use MiddlewareConnector\MiddlewareConnector;
use MiddlewareConnector\Requests\Article\GetArticleCollectionRequest;
use MiddlewareConnector\Requests\Auth\PostAuthTokenRequest;
use MiddlewareConnector\Requests\Auth\PostRefreshTokenRequest;
use PHPUnit\Framework\TestCase;
use Saloon\Exceptions\NoMockResponseFoundException;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

class AuthTest extends TestCase
{
    public function testRequestNewTokenWithUsernamePassword(): void
    {
        $mockClient = new MockClient([
            GetArticleCollectionRequest::class => new MockResponse([['name' => 'test']], 200),
            PostAuthTokenRequest::class => new MockResponse(['token' => 'MY_TEST_TOKEN', 'refresh_token' => ''], 200),
        ]);

        $connector = MiddlewareConnector::create(
            'username',
            'password',
            'wmsCode',
            'CustomerCode',
            MiddlewareConnector::BASE_URL_EU_DEV,
        )->withMockClient($mockClient);

        $response = $connector->send(new GetArticleCollectionRequest());
        $this->assertSame(200, $response->status());
        $this->assertSame([['name' => 'test']], $response->json());
    }

    public function testRequestNewTokenWithUsernamePasswordFailed(): void
    {
        $mockClient = new MockClient([
            GetArticleCollectionRequest::class => new MockResponse([['name' => 'test']], 200),
            PostAuthTokenRequest::class => new MockResponse(['token' => 'MY_TEST_TOKEN', 'refresh_token' => ''], 500),
        ]);

        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage('Could not fetch new token!');
        $connector = MiddlewareConnector::create(
            'username',
            'password',
            'wmsCode',
            'CustomerCode',
            MiddlewareConnector::BASE_URL_EU_DEV,
        )->withMockClient($mockClient);

//        $authenticatedConnector = $connector->authenticate(new MiddlewareAuthenticator(
//            username: 'username',
//            password: 'password',
//        ));

        $response = $connector->send(new GetArticleCollectionRequest());
    }

    public function testRequestNewTokenWithRefreshToken(): void
    {
        $mockClient = new MockClient([
            GetArticleCollectionRequest::class => new MockResponse([['name' => 'test']], 200),
            PostRefreshTokenRequest::class => new MockResponse(['token' => 'MY_TEST_TOKEN', 'refresh_token' => ''], 200),
        ]);

        $connector = MiddlewareConnector::createWithRefreshToken(
            'refreshToken',
            'wmsCode',
            'CustomerCode',
            MiddlewareConnector::BASE_URL_EU_DEV,
        )->withMockClient($mockClient);

        $response = $connector->send(new GetArticleCollectionRequest());
        $this->assertSame(200, $response->status());
    }

    public function testRequestNewTokenWithRefreshTokenFailed(): void
    {
        $mockClient = new MockClient([
            GetArticleCollectionRequest::class => new MockResponse([['name' => 'test']], 200),
            PostRefreshTokenRequest::class => new MockResponse(['token' => 'MY_TEST_TOKEN', 'refresh_token' => ''], 500),
        ]);

        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage('Could not refresh token!');

        $connector = MiddlewareConnector::createWithRefreshToken(
            'refreshToken',
            'wmsCode',
            'CustomerCode',
            MiddlewareConnector::BASE_URL_EU_DEV,
        )->withMockClient($mockClient);

        $response = $connector->send(new GetArticleCollectionRequest());
    }

    public function testRefreshTokenOnlyFetchedWhenExpired(): void
    {
        $mockClient = new MockClient([
            GetArticleCollectionRequest::class => new MockResponse([['name' => 'test']], 200),
            PostRefreshTokenRequest::class => new MockResponse(['token' => 'MY_TEST_TOKEN', 'refresh_token' => ''], 200),
        ]);

        $connector = MiddlewareConnector::createWithRefreshToken(
            'refreshToken',
            'wmsCode',
            'CustomerCode',
            MiddlewareConnector::BASE_URL_EU_DEV,
        )->withMockClient($mockClient);

        $response = $connector->send(new GetArticleCollectionRequest());
        $this->assertSame(200, $response->status());
        $mockClient->assertSentCount(2); // expect 1 auth call and 1 article call

        $response = $connector->send(new GetArticleCollectionRequest());
        $this->assertSame(200, $response->status());
        $mockClient->assertSentCount(3); // don't expect another auth call
    }
}
