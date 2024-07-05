<?php

namespace MiddlewareConnector\Requests\Customer;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetCustomerSingleRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return 'wms/customers/' . $this->uuid;
    }
    public function __construct(
        public string $uuid
    ) {
    }
}
