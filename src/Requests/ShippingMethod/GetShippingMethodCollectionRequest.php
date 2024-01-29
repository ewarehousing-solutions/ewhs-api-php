<?php

/**
 * User: Henny Krijnen
 * Date: 08-03-22 11:49
 * Copyright (c) eWarehousing Solutions
 */

namespace MiddlewareConnector\Requests\ShippingMethod;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetShippingMethodCollectionRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return 'wms/shippingmethods';
    }

    public function defaultHeaders(): array
    {
        return [
            'Expand' => implode(',', $this->expands),
        ];
    }

    public function __construct(
        public array $expands = [],
    ) {
    }
}
