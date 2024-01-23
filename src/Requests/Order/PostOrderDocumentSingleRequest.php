<?php

/*
 * User: Henny Krijnen
 * Date: 09-03-22 10:20
 * Copyright (c) eWarehousing Solutions
 */

namespace MiddlewareConnector\Requests\Order;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class PostOrderDocumentSingleRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return 'wms/orders/' . $this->uuid . '/documents/';
    }

    public function __construct(
        public string $uuid,
    ) {
    }
}
