<?php

/**
 * User: Henny Krijnen
 * Date: 08-03-22 14:55
 * Copyright (c) eWarehousing Solutions
 */

namespace MiddlewareConnector\Requests\Variant;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetVariantSingleRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return 'wms/variants/' . $this->uuid;
    }

    public function defaultHeaders(): array
    {
        return [
            'Expand' => implode(',', $this->expands),
        ];
    }

    public function __construct(
        public string $uuid,
        public array $expands = [],
    ) {
    }
}
