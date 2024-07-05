<?php

namespace MiddlewareConnector\Requests\Customer;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetCustomerCollectionRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return 'wms/customers';
    }
}
