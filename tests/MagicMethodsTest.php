<?php
/*
 * User: Henny Krijnen
 * Date: 08-03-22 11:49
 * Copyright (c) eWarehousing Solutions
 */

namespace MiddlewareConnector\Tests;

use http\Message\Body;
use MiddlewareConnector\Requests\Article\GetArticleCollectionRequest;
use MiddlewareConnector\Requests\Article\GetArticleSingleRequest;
use MiddlewareConnector\Requests\Article\PatchArticleSingleRequest;
use MiddlewareConnector\Requests\Article\PostArticleCollectionRequest;
use MiddlewareConnector\Requests\Article\PostArticleSingleRequest;
use MiddlewareConnector\Requests\Batch\GetBatchCollectionRequest;
use MiddlewareConnector\Requests\Batch\GetBatchSingleRequest;
use MiddlewareConnector\Requests\Inbound\GetInboundCollectionRequest;
use MiddlewareConnector\Requests\Inbound\GetInboundSingleRequest;
use MiddlewareConnector\Requests\Inbound\PatchInboundSingleCancelRequest;
use MiddlewareConnector\Requests\Inbound\PatchInboundSingleRequest;
use MiddlewareConnector\Requests\Inbound\PostInboundSingleRequest;
use MiddlewareConnector\Requests\Logs\GetLogsCollectionRequest;
use MiddlewareConnector\Requests\Order\GetOrderCollectionRequest;
use MiddlewareConnector\Requests\Order\GetOrderDocumentCollectionRequest;
use MiddlewareConnector\Requests\Order\GetOrderDocumentSingleRequest;
use MiddlewareConnector\Requests\Order\GetOrderSingleRequest;
use MiddlewareConnector\Requests\Order\PatchOrderSingleCancelRequest;
use MiddlewareConnector\Requests\Order\PatchOrderSingleRequest;
use MiddlewareConnector\Requests\Order\PostOrderDocumentSingleRequest;
use MiddlewareConnector\Requests\Order\PostOrderSingleRequest;
use MiddlewareConnector\Requests\Shipment\GetShipmentCollectionRequest;
use MiddlewareConnector\Requests\Shipment\GetShipmentSingleRequest;
use MiddlewareConnector\Requests\ShippingMethod\GetShippingMethodCollectionRequest;
use MiddlewareConnector\Requests\ShippingMethod\GetShippingMethodSingleRequest;
use MiddlewareConnector\Requests\StockLevel\GetStockLevelCollectionRequest;
use MiddlewareConnector\Requests\Variant\GetVariantCollectionRequest;
use MiddlewareConnector\Requests\Variant\GetVariantSingleRequest;
use MiddlewareConnector\Requests\Variant\PatchVariantSingleRequest;
use MiddlewareConnector\Requests\Variant\PostVariantSingleRequest;
use MiddlewareConnector\Requests\Webhook\GetWebhookCollectionRequest;
use MiddlewareConnector\Requests\Webhook\PostWebhookSingleRequest;
use PHPUnit\Framework\TestCase;
use Saloon\Http\Faking\MockResponse;

class MagicMethodsTest extends TestCase
{
    use ConnectorTrait;

    public function testArticleMagicMethods(): void
    {
        $mockClient = $this->getMockClient([
            GetArticleCollectionRequest::class => new MockResponse([['name' => 'test']], 200),
            GetArticleSingleRequest::class => new MockResponse([['name' => 'test']], 200),
            PatchArticleSingleRequest::class => new MockResponse([['name' => 'test']], 200),
            PostArticleSingleRequest::class => new MockResponse([['name' => 'test']], 200),
            PostArticleCollectionRequest::class => new MockResponse([['name' => 'test']], 200),
        ]);

        $connector = $this->getConnector($mockClient);
        $response = $connector->send(new GetArticleSingleRequest('A_RANDOM_ID'));
        $this->assertSame(200, $response->status());
        $this->assertSame([['name' => 'test']], $response->json());

        $response = $connector->send(new GetArticleCollectionRequest());
        $this->assertSame(200, $response->status());
        $this->assertSame([['name' => 'test']], $response->json());

        $patch = new PatchArticleSingleRequest('A_RANDOM_ID');
        $patch->body()->set([]);
        $response = $connector->send($patch);

        $this->assertSame(200, $response->status());
        $this->assertSame([['name' => 'test']], $response->json());

        $post = new PostArticleSingleRequest();
        $post->body()->set([
            'name' => 'test',
        ]);
        $response = $connector->send($post);
        $this->assertSame(200, $response->status());
        $this->assertSame([['name' => 'test']], $response->json());

        $post = new PostArticleCollectionRequest();
        $post->body()->set([[
            'name' => 'test',
        ]]);
        $response = $connector->send($post);
        $this->assertSame(200, $response->status());
        $this->assertSame([['name' => 'test']], $response->json());

        $mockClient->assertSentCount(6); // 1 auth, 5 article calls
    }
}
