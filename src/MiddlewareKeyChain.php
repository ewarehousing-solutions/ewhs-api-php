<?php

/**
 * User: Henny Krijnen
 * Date: 08-03-22 11:49
 * Copyright (c) eWarehousing Solutions
 */

namespace MiddlewareConnector;

use DateTime;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use MiddlewareConnector\Requests\Auth\PostAuthTokenRequest;
use MiddlewareConnector\Requests\Auth\PostRefreshTokenRequest;
use Saloon\Contracts\PendingRequest;
use MiddlewareConnector\Exceptions\AuthenticationException;

class MiddlewareKeyChain implements \Saloon\Contracts\Authenticator
{
    private ?DateTime $tokenExpiresAt = null;
    private ?string $token = null;

    public function __construct(
        protected ?string $username = null,
        protected ?string $password = null,
        protected ?string $refreshToken = null,
    ) {
    }

    /**
     * Called every request
     *
     * @param PendingRequest $pendingRequest
     * @return void
     * @throws AuthenticationException
     * @throws GuzzleException
     * @throws \ReflectionException
     */
    public function boot(PendingRequest $pendingRequest): void
    {
        if ($this->tokenExpiresAt == null || $this->tokenExpiresAt < new DateTime()) {
            $this->fetchToken($pendingRequest);
        }

        if ($this->token) {
            $pendingRequest->getConnector()->withTokenAuth($this->token);
        }
    }

    /**
     * Fetch token logic
     *
     * @param PendingRequest $pendingRequest
     *
     * @return void
     *
     * @throws AuthenticationException
     * @throws GuzzleException
     * @throws \ReflectionException
     */
    private function fetchToken(PendingRequest $pendingRequest): void
    {
        Log::Info('ghellef');
        if (!$this->shouldFetch($pendingRequest)) {
            return;
        }

        /** @var MiddlewareConnector $connector */
        $connector = $pendingRequest->getConnector();

        if ($this->refreshToken === null) {
            $request = new postAuthTokenRequest(
                username: $this->username,
                password: $this->password,
            );
            $auth = $connector->send($request);
//            $auth =  $connector->postAuthTokenRequest(
//                username: $this->username,
//                password: $this->password,
//            )-> ($connector->getConfig('mockClient'));

            if ($auth->status() !== 200) {
                throw new AuthenticationException('Could not fetch new token!');
            }
        } else {
            $request = new PostRefreshTokenRequest(
                refreshToken: $this->refreshToken,
            );
            $auth = $connector->send($request);

            if ($auth->status() !== 200) {
                throw new AuthenticationException('Could not refresh token!');
            }
        }

        $dateTime = new DateTime();
        $dateTime->modify('+45 minutes');
        $this->tokenExpiresAt = $dateTime;
        $this->token = $auth->json()['token'] ?? null;
        $this->refreshToken = $auth->json()['refresh_token'] ?? null;
    }

    /**
     * Validates if we need to auth for current route
     *
     * @param  PendingRequest $pendingRequest
     * @return bool
     */
    private function shouldFetch(PendingRequest $pendingRequest): bool
    {
        if (
            $pendingRequest->getUrl() !== (new PostAuthTokenRequest('ignore', 'ignore'))->resolveEndpoint()
            && $pendingRequest->getUrl() !== (new PostRefreshTokenRequest('ignore'))->resolveEndpoint()
        ) {
            return true;
        }

        return false;
    }

    public function set(PendingRequest $pendingRequest): void
    {
        // TODO: Implement set() method.
    }
}
