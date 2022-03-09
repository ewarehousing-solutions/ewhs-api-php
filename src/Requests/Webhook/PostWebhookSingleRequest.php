<?php

/*
 * User: Henny Krijnen
 * Date: 09-03-22 10:20
 * Copyright (c) eWarehousing Solutions
 */

namespace MiddlewareConnector\Requests\Webhook;

use Sammyjo20\Saloon\Constants\Saloon;
use Sammyjo20\Saloon\Http\SaloonRequest;
use Sammyjo20\Saloon\Traits\Plugins\HasJsonBody;

class PostWebhookSingleRequest extends SaloonRequest
{
    use HasJsonBody;

    protected ?string $method = Saloon::POST;

    public function defineEndpoint(): string
    {
        return 'webhooks/';
    }
}
