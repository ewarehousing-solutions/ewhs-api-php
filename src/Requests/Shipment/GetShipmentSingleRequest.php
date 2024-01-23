<?php

/**
 * User: Henny Krijnen
 * Date: 08-03-22 14:55
 * Copyright (c) eWarehousing Solutions
 */

namespace MiddlewareConnector\Requests\Shipment;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetShipmentSingleRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return 'wms/shipments/' . $this->uuid;
    }

    public function __construct(
        public string $uuid
    ) {
    }
}
