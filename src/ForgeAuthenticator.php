<?php

namespace MiddlewareConnector;

use MiddlewareConnector\Requests\Auth\PostAuthTokenRequest;
use Saloon\Contracts\PendingRequest;
use Saloon\Contracts\Authenticator;

class ForgeAuthenticator implements Authenticator
{
    public function __construct(
        protected string $username,
        protected string $password,
    ) {
    }

    public function set(PendingRequest $pendingRequest): void
    {
        // Make sure to ignore the authentication request to prevent loops.

        if ($pendingRequest->getRequest() instanceof postAuthTokenRequest) {
            return;
        }

        // Make a request to the Authentication endpoint using the same connector.

        $response = $pendingRequest->getConnector()->send(new postAuthTokenRequest(
            $this->username,
            $this->password,
        ));

        // Finally, authenticate the previous PendingRequest before it is sent.

        $pendingRequest->headers()->add('Authorization', 'Bearer ' . $response->json('token'));
    }
}