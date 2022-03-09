<?php

/**
 * User: Henny Krijnen
 * Date: 08-03-22 11:49
 * Copyright (c) eWarehousing Solutions
 */

namespace MiddlewareConnector\Requests\ShippingMethod;

use Sammyjo20\Saloon\Constants\Saloon;
use Sammyjo20\Saloon\Http\SaloonRequest;

class GetShippingMethodCollectionRequest extends SaloonRequest
{
    protected ?string $method = Saloon::GET;

    public function defineEndpoint(): string
    {
        return 'wms/shippingmethods';
    }
}
