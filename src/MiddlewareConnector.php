<?php

/**
 * User: Henny Krijnen
 * Date: 08-03-22 11:49
 * Copyright (c) eWarehousing Solutions
 */

namespace MiddlewareConnector;

use Sammyjo20\Saloon\Http\SaloonConnector;
use MiddlewareConnector\Requests\Article\GetArticleCollectionRequest;
use MiddlewareConnector\Requests\Article\GetArticleSingleRequest;
use MiddlewareConnector\Requests\Article\PostArticleCollectionRequest;
use MiddlewareConnector\Requests\Article\PostArticleSingleRequest;
use MiddlewareConnector\Requests\Auth\PostAuthTokenRequest;
use MiddlewareConnector\Requests\Auth\PostRefreshTokenRequest;
use Sammyjo20\Saloon\Http\SaloonRequest;

/**
 * @method GetArticleCollectionRequest getArticleCollectionRequest
 * @method GetArticleSingleRequest getArticleSingleRequest(string $uuid)
 * @method PostArticleCollectionRequest postArticleCollectionRequest
 * @method PostArticleSingleRequest postArticleSingleRequest
 * @method PostRefreshTokenRequest postRefreshTokenRequest(string $refreshToken)
 * @method PostAuthTokenRequest postAuthTokenRequest(string $username, string $password)
 */
class MiddlewareConnector extends SaloonConnector
{
    public const BASE_URL_EU_DEV = 'https://eu-dev.middleware.ewarehousing-solutions.com';
    public const BASE_URL_EU = 'https://eu.middleware.ewarehousing-solutions.com';
    public const BASE_URL_US = 'https://us.middleware.ewarehousing-solutions.com';

    protected array $requests = [
        GetArticleCollectionRequest::class,
        GetArticleSingleRequest::class,
        PostArticleCollectionRequest::class,
        PostArticleSingleRequest::class,
        PostRefreshTokenRequest::class,
        PostAuthTokenRequest::class,
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
    ) {
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
    ) {
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
