<?php

/**
 * User: Henny Krijnen
 * Date: 08-03-22 11:49
 * Copyright (c) eWarehousing Solutions
 */

namespace MiddlewareConnector;

use DateTime;
use GuzzleHttp\Exception\GuzzleException;
use MiddlewareConnector\Requests\Auth\PostAuthTokenRequest;
use MiddlewareConnector\Requests\Auth\PostRefreshTokenRequest;
use Sammyjo20\Saloon\Exceptions\SaloonException;
use Sammyjo20\Saloon\Exceptions\SaloonInvalidConnectorException;
use Sammyjo20\Saloon\Helpers\Keychain;
use Sammyjo20\Saloon\Http\SaloonRequest;
use MiddlewareConnector\Exceptions\AuthenticationException;

class MiddlewareKeyChain extends Keychain
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
     * @param  SaloonRequest $request
     * @return void
     * @throws AuthenticationException
     * @throws GuzzleException
     * @throws SaloonException
     * @throws SaloonInvalidConnectorException
     * @throws \ReflectionException
     */
    public function boot(SaloonRequest $request): void
    {
        if ($this->tokenExpiresAt == null || $this->tokenExpiresAt < new DateTime()) {
            $this->fetchToken($request);
        }

        if ($this->token) {
            $request->withToken($this->token);
        }
    }

    /**
     * Fetch token logic
     *
     * @param SaloonRequest $request
     *
     * @return void
     *
     * @throws AuthenticationException
     * @throws GuzzleException
     * @throws \ReflectionException
     * @throws SaloonException
     * @throws SaloonInvalidConnectorException
     */
    private function fetchToken(SaloonRequest $request): void
    {
        if (!$this->shouldFetch($request)) {
            return;
        }

        /** @var MiddlewareConnector $connector */
        $connector = $request->getConnector();

        if ($this->refreshToken === null) {
            $auth = $connector->postAuthTokenRequest(
                username: $this->username,
                password: $this->password,
            )->send($connector->getConfig('mockClient'));

            if ($auth->status() !== 200) {
                throw new AuthenticationException('Could not fetch new token!');
            }
        } else {
            $auth = $connector->postRefreshTokenRequest(
                refreshToken: $this->refreshToken,
            )->send($connector->getConfig('mockClient'));

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
     * @param  SaloonRequest $request
     * @return bool
     */
    private function shouldFetch(SaloonRequest $request): bool
    {
        if (
            $request->defineEndpoint() !== (new PostAuthTokenRequest('ignore', 'ignore'))->defineEndpoint()
            && $request->defineEndpoint() !== (new PostRefreshTokenRequest('ignore'))->defineEndpoint()
        ) {
            return true;
        }

        return false;
    }
}
