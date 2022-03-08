<?php

/**
 * User: Henny Krijnen
 * Date: 08-03-22 11:49
 * Copyright (c) eWarehousing Solutions
 */

namespace MiddlewareConnector\Requests\Auth;

use Sammyjo20\Saloon\Constants\Saloon;
use Sammyjo20\Saloon\Http\SaloonRequest;
use Sammyjo20\Saloon\Traits\Plugins\HasJsonBody;

class PostRefreshTokenRequest extends SaloonRequest
{
    use HasJsonBody;

    protected ?string $method = Saloon::POST;

    public function defineEndpoint(): string
    {
        return '/wms/auth/refresh/';
    }

    public function defaultData(): array
    {
        return [
            'refresh_token' => $this->refreshToken,
        ];
    }

    public function __construct(
        public string $refreshToken
    ) {
    }
}
