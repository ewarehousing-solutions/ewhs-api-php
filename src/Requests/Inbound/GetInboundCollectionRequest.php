<?php

/*
 * User: Henny Krijnen
 * Date: 09-03-22 10:20
 * Copyright (c) eWarehousing Solutions
 */

namespace MiddlewareConnector\Requests\Inbound;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\Paginatable;

class GetInboundCollectionRequest extends Request implements Paginatable
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return 'wms/inbounds';
    }
}
