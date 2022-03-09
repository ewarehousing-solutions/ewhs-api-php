<?php

/*
 * User: Henny Krijnen
 * Date: 09-03-22 10:20
 * Copyright (c) eWarehousing Solutions
 */

namespace MiddlewareConnector\Requests\Order;

use Sammyjo20\Saloon\Constants\Saloon;
use Sammyjo20\Saloon\Http\SaloonRequest;
use Sammyjo20\Saloon\Traits\Plugins\HasJsonBody;

class PatchOrderSingleRequest extends SaloonRequest
{
    use HasJsonBody;

    protected ?string $method = Saloon::PATCH;

    public function defineEndpoint(): string
    {
        return 'wms/orders/' . $this->uuid;
    }

    public function __construct(
        public string $uuid
    ) {
    }
}
