<?php
/*
 * User: Henny Krijnen
 * Date: 08-03-22 11:49
 * Copyright (c) eWarehousing Solutions
 */

namespace MiddlewareConnector\Tests\Articles;

use MiddlewareConnector\MiddlewareConnector;
use MiddlewareConnector\Requests\Article\GetArticleCollectionRequest;
use MiddlewareConnector\Requests\Article\GetArticleSingleRequest;
use MiddlewareConnector\Requests\Article\PostArticleCollectionRequest;
use MiddlewareConnector\Requests\Article\PostArticleSingleRequest;
use MiddlewareConnector\Requests\Auth\PostAuthTokenRequest;
use MiddlewareConnector\Requests\Auth\PostRefreshTokenRequest;
use MiddlewareConnector\Tests\ConnectorTrait;
use PHPUnit\Framework\TestCase;
use Sammyjo20\Saloon\Clients\MockClient;
use Sammyjo20\Saloon\Http\MockResponse;

class ArticlesTest extends TestCase
{
    use ConnectorTrait;

    public function testAvailableMagicMethods(): void
    {
        $mockClient = $this->getMockClient([
            GetArticleCollectionRequest::class => new MockResponse([['name' => 'test']], 200),
            GetArticleSingleRequest::class => new MockResponse([['name' => 'test']], 200),
            PostArticleSingleRequest::class => new MockResponse([['name' => 'test']], 200),
            PostArticleCollectionRequest::class => new MockResponse([['name' => 'test']], 200),
        ]);

        $connector = $this->getConnector($mockClient);
        $response = $connector->getArticleCollectionRequest()->send($mockClient);
        $response = $connector->postArticleCollectionRequest()->send($mockClient);
        $response = $connector->postArticleSingleRequest()->send($mockClient);
        $response = $connector->postArticleCollectionRequest()->send($mockClient);

        $mockClient->assertSentCount(5); // 1 auth, 4 article calls
    }
}
