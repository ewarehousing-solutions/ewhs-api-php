<?php

/*
 * User: Henny Krijnen
 * Date: 09-03-22 10:20
 * Copyright (c) eWarehousing Solutions
 */

namespace MiddlewareConnector\Requests\Webhook;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteWebhookSingleRequest extends Request
{
    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return 'webhooks/' . $this->id . '/';
    }

    public function __construct(public string $id)
    {
    }
}
