<?php

namespace MiddlewareConnector;

use MiddlewareConnector\Exceptions\AuthenticationException;
use MiddlewareConnector\Requests\Auth\PostAuthTokenRequest;
use MiddlewareConnector\Requests\Auth\PostRefreshTokenRequest;
use Saloon\Contracts\Authenticator;
use Saloon\Http\PendingRequest;

class MiddlewareAuthenticator implements Authenticator
{
    public function __construct(
        protected ?string $username = null,
        protected ?string $password = null,
        protected ?string $refreshToken = null,
    ) {
    }

    public function set(PendingRequest $pendingRequest): void
    {
        // Make sure to ignore the authentication request to prevent loops.
        if ($pendingRequest->getRequest() instanceof PostAuthTokenRequest
            || $pendingRequest->getRequest() instanceof PostRefreshTokenRequest) {
            return;
        }
        $connector = $pendingRequest->getConnector();

        $tokenExpiresAt = $connector->config()->get('token_expires_at');
        $refreshToken = $connector->config()->get('refresh_token') ?? $this->refreshToken;
        if ($tokenExpiresAt == null || $tokenExpiresAt < new \DateTime()) {
            if ($refreshToken === null) {
                $auth = $connector->send(new PostAuthTokenRequest(
                    username: $this->username,
                    password: $this->password,
                ));
                if ($auth->status() !== 200) {
                    throw new AuthenticationException('Could not fetch new token!');
                }
            } else {
                $auth = $connector->send(new PostRefreshTokenRequest(
                    refreshToken: $refreshToken,
                ));
                if ($auth->status() !== 200) {
                    throw new AuthenticationException('Could not refresh token!');
                }
            }

            $dateTime = new \DateTime();
            $dateTime->modify('+45 minutes');
            $connector->config()->add('token_expires_at', $dateTime);
            $connector->config()->add('refresh_token', $auth->json('refresh_token'));
            $connector->config()->add('token', $auth->json('token'));
        }

        $token = $connector->config()->get('token');
        // Finally, authenticate the previous PendingRequest before it is sent.
        $pendingRequest->headers()->add('Authorization', 'Bearer ' . $token);
    }
}
