<?php

/*
 * User: Henny Krijnen
 * Date: 09-03-22 10:20
 * Copyright (c) eWarehousing Solutions
 */

namespace MiddlewareConnector\Requests\Order;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\Paginatable;

class GetOrderDocumentCollectionRequest extends Request implements Paginatable
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return 'wms/orders/' . $this->uuid . '/documents';
    }

    public function __construct(
        public string $uuid,
    ) {
    }
}
