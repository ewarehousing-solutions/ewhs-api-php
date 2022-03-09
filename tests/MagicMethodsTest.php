<?php
/*
 * User: Henny Krijnen
 * Date: 08-03-22 11:49
 * Copyright (c) eWarehousing Solutions
 */

namespace MiddlewareConnector\Tests;

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
use Sammyjo20\Saloon\Http\MockResponse;

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
        $connector->getArticleSingleRequest('A_RANDOM_ID')->send($mockClient);
        $connector->getArticleCollectionRequest()->send($mockClient);
        $connector->patchArticleSingleRequest('A_RANDOM_ID')->setData([])->send($mockClient);
        $connector->postArticleSingleRequest()->setData([])->send($mockClient);
        $connector->postArticleCollectionRequest()->setData([])->send($mockClient);

        $mockClient->assertSentCount(6); // 1 auth, 5 article calls
    }

    public function testBatchMagicMethods(): void
    {
        $mockClient = $this->getMockClient([
            GetBatchCollectionRequest::class => new MockResponse([['name' => 'test']], 200),
            GetBatchSingleRequest::class => new MockResponse([['name' => 'test']], 200),
        ]);

        $connector = $this->getConnector($mockClient);
        $connector->getBatchCollectionRequest()->send($mockClient);
        $connector->getBatchSingleRequest('A_RANDOM_ID')->send($mockClient);

        $mockClient->assertSentCount(3);
    }

    public function testInboundMagicMethods(): void
    {
        $mockClient = $this->getMockClient([
            GetInboundCollectionRequest::class => new MockResponse([['name' => 'test']], 200),
            GetInboundSingleRequest::class => new MockResponse([['name' => 'test']], 200),
            PatchInboundSingleCancelRequest::class => new MockResponse([['name' => 'test']], 200),
            PatchInboundSingleRequest::class => new MockResponse([['name' => 'test']], 200),
            PostInboundSingleRequest::class => new MockResponse([['name' => 'test']], 200),
        ]);

        $connector = $this->getConnector($mockClient);
        $connector->getInboundCollectionRequest()->send($mockClient);
        $connector->getInboundSingleRequest('A_RANDOM_ID')->send($mockClient);
        $connector->patchInboundSingleCancelRequest('A_RANDOM_ID')->send($mockClient);
        $connector->patchInboundSingleRequest('A_RANDOM_ID')->send($mockClient);
        $connector->postInboundSingleRequest()->send($mockClient);

        $mockClient->assertSentCount(6);
    }

    public function testLogMagicMethods(): void
    {
        $mockClient = $this->getMockClient([
            GetLogsCollectionRequest::class => new MockResponse([['name' => 'test']], 200),
        ]);

        $connector = $this->getConnector($mockClient);
        $connector->getLogsCollectionRequest()->send($mockClient);

        $mockClient->assertSentCount(2);
    }

    public function testOrderMagicMethods(): void
    {
        $mockClient = $this->getMockClient([
            GetOrderCollectionRequest::class => new MockResponse([['name' => 'test']], 200),
            GetOrderDocumentCollectionRequest::class => new MockResponse([['name' => 'test']], 200),
            GetOrderDocumentSingleRequest::class => new MockResponse([['name' => 'test']], 200),
            GetOrderSingleRequest::class => new MockResponse([['name' => 'test']], 200),
            PatchOrderSingleCancelRequest::class => new MockResponse([['name' => 'test']], 200),
            PatchOrderSingleRequest::class => new MockResponse([['name' => 'test']], 200),
            PostOrderDocumentSingleRequest::class => new MockResponse([['name' => 'test']], 200),
            PostOrderSingleRequest::class => new MockResponse([['name' => 'test']], 200),
        ]);

        $connector = $this->getConnector($mockClient);
        $connector->getOrderCollectionRequest()->send($mockClient);
        $connector->getOrderDocumentCollectionRequest("A_RANDOM_UUID")->send($mockClient);
        $connector->getOrderDocumentSingleRequest("A_RANDOM_UUID", "A_RANDOM_UUID")->send($mockClient);
        $connector->getOrderSingleRequest("A_RANDOM_UUID")->send($mockClient);
        $connector->patchOrderSingleCancelRequest("A_RANDOM_UUID")->send($mockClient);
        $connector->patchOrderSingleRequest("A_RANDOM_UUID")->send($mockClient);
        $connector->postOrderDocumentSingleRequest("A_RANDOM_UUID")->send($mockClient);
        $connector->postOrderSingleRequest()->send($mockClient);

        $mockClient->assertSentCount(9);
    }

    public function testShipmentMagicMethods(): void
    {
        $mockClient = $this->getMockClient([
            GetShipmentCollectionRequest::class => new MockResponse([['name' => 'test']], 200),
            GetShipmentSingleRequest::class => new MockResponse([['name' => 'test']], 200),
        ]);

        $connector = $this->getConnector($mockClient);
        $connector->getShipmentCollectionRequest()->send($mockClient);
        $connector->getShipmentSingleRequest("A_RANDOM_UUID")->send($mockClient);

        $mockClient->assertSentCount(3);
    }

    public function testShippingMethodMagicMethods(): void
    {
        $mockClient = $this->getMockClient([
            GetShippingMethodCollectionRequest::class => new MockResponse([['name' => 'test']], 200),
            GetShippingMethodSingleRequest::class => new MockResponse([['name' => 'test']], 200),
        ]);

        $connector = $this->getConnector($mockClient);
        $connector->getShippingMethodCollectionRequest()->send($mockClient);
        $connector->getShippingMethodSingleRequest("A_RANDOM_UUID")->send($mockClient);

        $mockClient->assertSentCount(3);
    }

    public function testStockLevelMagicMethods(): void
    {
        $mockClient = $this->getMockClient([
            GetStockLevelCollectionRequest::class => new MockResponse([['name' => 'test']], 200),
        ]);

        $connector = $this->getConnector($mockClient);
        $connector->getStockLevelCollectionRequest()->send($mockClient);

        $mockClient->assertSentCount(2);
    }

    public function testVariantMagicMethods(): void
    {
        $mockClient = $this->getMockClient([
            GetVariantCollectionRequest::class => new MockResponse([['name' => 'test']], 200),
            GetVariantSingleRequest::class => new MockResponse([['name' => 'test']], 200),
            PatchVariantSingleRequest::class => new MockResponse([['name' => 'test']], 200),
            PostVariantSingleRequest::class => new MockResponse([['name' => 'test']], 200),
        ]);

        $connector = $this->getConnector($mockClient);
        $connector->getVariantCollectionRequest()->send($mockClient);
        $connector->getVariantSingleRequest('A_RANDOM_ID')->send($mockClient);
        $connector->patchVariantSingleRequest('A_RANDOM_ID')->send($mockClient);
        $connector->postVariantSingleRequest()->send($mockClient);

        $mockClient->assertSentCount(5);
    }

    public function testWebhookMagicMethods(): void
    {
        $mockClient = $this->getMockClient([
            GetWebhookCollectionRequest::class => new MockResponse([['name' => 'test']], 200),
            PostWebhookSingleRequest::class => new MockResponse([['name' => 'test']], 200),
        ]);

        $connector = $this->getConnector($mockClient);
        $connector->getWebhookCollectionRequest()->send($mockClient);
        $connector->postWebhookSingleRequest()->send($mockClient);
        $mockClient->assertSentCount(3);
    }
}
