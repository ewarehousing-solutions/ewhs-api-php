<?php

/**
 * User: Henny Krijnen
 * Date: 08-03-22 11:49
 * Copyright (c) eWarehousing Solutions
 */

namespace MiddlewareConnector\Requests\Article;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetArticleSingleRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return 'wms/articles/' . $this->uuid;
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
