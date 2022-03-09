<?php

/**
 * User: Henny Krijnen
 * Date: 08-03-22 11:49
 * Copyright (c) eWarehousing Solutions
 */

namespace MiddlewareConnector;

use MiddlewareConnector\Requests\Inbound\GetInboundCollectionRequest;
use MiddlewareConnector\Requests\Inbound\GetInboundSingleRequest;
use MiddlewareConnector\Requests\Inbound\PatchInboundSingleCancelRequest;
use MiddlewareConnector\Requests\Inbound\PatchInboundSingleRequest;
use MiddlewareConnector\Requests\Inbound\PostInboundSingleRequest;
use MiddlewareConnector\Requests\Logs\GetLogsCollectionRequest;
use MiddlewareConnector\Requests\Article\GetArticleCollectionRequest;
use MiddlewareConnector\Requests\Article\GetArticleSingleRequest;
use MiddlewareConnector\Requests\Article\PostArticleCollectionRequest;
use MiddlewareConnector\Requests\Article\PostArticleSingleRequest;
use MiddlewareConnector\Requests\Article\PatchArticleSingleRequest;
use MiddlewareConnector\Requests\Batch\GetBatchCollectionRequest;
use MiddlewareConnector\Requests\Batch\GetBatchSingleRequest;
use MiddlewareConnector\Requests\Auth\PostAuthTokenRequest;
use MiddlewareConnector\Requests\Auth\PostRefreshTokenRequest;
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
use Sammyjo20\Saloon\Http\SaloonConnector;
use Sammyjo20\Saloon\Http\SaloonRequest;

/**
 * @method GetArticleCollectionRequest getArticleCollectionRequest
 * @method GetArticleSingleRequest getArticleSingleRequest(string $uuid)
 * @method PostArticleCollectionRequest postArticleCollectionRequest
 * @method PostArticleSingleRequest postArticleSingleRequest
 * @method PatchArticleSingleRequest patchArticleSingleRequest(string $uuid)
 *
 * @method GetBatchCollectionRequest getBatchCollectionRequest
 * @method GetBatchSingleRequest getBatchSingleRequest(string $uuid)
 *
 * @method GetInboundCollectionRequest getInboundCollectionRequest
 * @method GetInboundSingleRequest GetInboundSingleRequest(string $uuid)
 * @method PostInboundSingleRequest postInboundSingleRequest
 * @method PatchInboundSingleRequest patchInboundSingleRequest(string $uuid)
 * @method PatchInboundSingleCancelRequest patchInboundSingleCancelRequest(string $uuid)
 *
 * @method GetLogsCollectionRequest getLogsCollectionRequest
 *
 * @method GetOrderCollectionRequest getOrderCollectionRequest
 * @method GetOrderDocumentCollectionRequest getOrderDocumentCollectionRequest(string $uuid)
 * @method GetOrderDocumentSingleRequest getOrderDocumentSingleRequest(string $uuid, string $documentUuid)
 * @method GetOrderSingleRequest getOrderSingleRequest(string $uuid)
 * @method PatchOrderSingleCancelRequest patchOrderSingleCancelRequest(string $uuid)
 * @method PatchOrderSingleRequest patchOrderSingleRequest(string $uuid)
 * @method PostOrderDocumentSingleRequest postOrderDocumentSingleRequest(string $uuid)
 * @method PostOrderSingleRequest postOrderSingleRequest
 *
 * @method GetShipmentCollectionRequest getShipmentCollectionRequest
 * @method GetShipmentSingleRequest getShipmentSingleRequest(string $uuid)
 *
 * @method GetStockLevelCollectionRequest getStockLevelCollectionRequest
 *
 * @method GetVariantCollectionRequest GetVariantCollectionRequest
 * @method GetVariantSingleRequest GetVariantSingleRequest(string $uuid)
 * @method PatchVariantSingleRequest PatchVariantSingleRequest(string $uuid)
 * @method PostVariantSingleRequest PostVariantSingleRequest
 *
 * @method GetShippingMethodCollectionRequest getShippingMethodCollectionRequest
 * @method GetShippingMethodSingleRequest getShippingMethodSingleRequest(string $uuid)
 *
 * @method PostRefreshTokenRequest postRefreshTokenRequest(string $refreshToken)
 * @method PostAuthTokenRequest postAuthTokenRequest(string $username, string $password)
 *
 * @method GetWebhookCollectionRequest getWebhookCollectionRequest
 * @method PostWebhookSingleRequest postWebhookSingleRequest
 */
class MiddlewareConnector extends SaloonConnector
{
    public const BASE_URL_EU_DEV = 'https://eu-dev.middleware.ewarehousing-solutions.com';
    public const BASE_URL_EU = 'https://eu.middleware.ewarehousing-solutions.com';
    public const BASE_URL_US = 'https://us.middleware.ewarehousing-solutions.com';

    protected array $requests = [
        # articles
        GetArticleCollectionRequest::class,
        GetArticleSingleRequest::class,
        PostArticleCollectionRequest::class,
        PostArticleSingleRequest::class,
        PatchArticleSingleRequest::class,
        # batches
        GetBatchCollectionRequest::class,
        GetBatchSingleRequest::class,
        # inbounds
        GetInboundCollectionRequest::class,
        GetInboundSingleRequest::class,
        PatchInboundSingleRequest::class,
        PatchInboundSingleCancelRequest::class,
        PostInboundSingleRequest::class,
        # logs
        GetLogsCollectionRequest::class,
        # orders
        GetOrderCollectionRequest::class,
        GetOrderDocumentCollectionRequest::class,
        GetOrderDocumentSingleRequest::class,
        GetOrderSingleRequest::class,
        PatchOrderSingleCancelRequest::class,
        PatchOrderSingleRequest::class,
        PostOrderDocumentSingleRequest::class,
        PostOrderSingleRequest::class,
        # shipments
        GetShipmentCollectionRequest::class,
        GetShipmentSingleRequest::class,
        # shippingmethods
        GetShippingMethodCollectionRequest::class,
        GetShippingMethodSingleRequest::class,
        # stocklevels
        GetStockLevelCollectionRequest::class,
        # variants
        GetVariantCollectionRequest::class,
        GetVariantSingleRequest::class,
        PatchVariantSingleRequest::class,
        PostVariantSingleRequest::class,
        # auth
        PostRefreshTokenRequest::class,
        PostAuthTokenRequest::class,
        # webhooks
        GetWebhookCollectionRequest ::class,
        PostWebhookSingleRequest::class,
    ];

    private MiddlewareKeyChain $middlewareKeyChain;

    public function __construct(
        private string $wmsCode,
        private string $customerCode,
        private string $baseUrl = self::BASE_URL_EU_DEV,
        private ?string $username = null,
        private ?string $password = null,
        private ?string $refreshToken = null,
    ) {
        $this->middlewareKeyChain = new MiddlewareKeyChain($this->username, $this->password, $this->refreshToken);
    }

    public static function create(
        string $username,
        string $password,
        string $wmsCode,
        string $customerCode,
        string $baseUrl = self::BASE_URL_EU_DEV,
    ): static {
        return new static(
            wmsCode: $wmsCode,
            customerCode: $customerCode,
            baseUrl: $baseUrl,
            username: $username,
            password: $password,
        );
    }

    public static function createWithRefreshToken(
        string $refreshToken,
        string $wmsCode,
        string $customerCode,
        string $baseUrl = self::BASE_URL_EU_DEV,
    ): static {
        return new static(
            wmsCode: $wmsCode,
            customerCode: $customerCode,
            baseUrl: $baseUrl,
            refreshToken: $refreshToken,
        );
    }

    public function defineBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function defaultHeaders(): array
    {
        return [
            'Accept' => '*/*',
            'Content-Type' => 'application/json',
            'User-Agent' => 'eWarehousingSolutions/2.0.0',
            'X-Customer-Code' => $this->customerCode,
            'X-WMS-Code' => $this->wmsCode,
        ];
    }

    public function defaultConfig(): array
    {
        return [
            'timeout' => 30,
        //            'debug' => true,
        ];
    }

    public function boot(SaloonRequest $request): void
    {
        $this->authenticate($this->middlewareKeyChain);
    }
}
