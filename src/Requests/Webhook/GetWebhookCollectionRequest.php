<?php

/**
 * User: Henny Krijnen
 * Date: 08-03-22 11:49
 * Copyright (c) eWarehousing Solutions
 */

namespace MiddlewareConnector\Requests\Webhook;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\Paginatable;

class GetWebhookCollectionRequest extends Request implements Paginatable
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return 'webhooks';
    }
}
