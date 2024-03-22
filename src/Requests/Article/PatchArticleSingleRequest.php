<?php

/**
 * User: Henny Krijnen
 * Date: 08-03-22 14:54
 * Copyright (c) eWarehousing Solutions
 */

namespace MiddlewareConnector\Requests\Article;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class PatchArticleSingleRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function resolveEndpoint(): string
    {
        return 'wms/articles/' . $this->uuid . '/';
    }

    public function __construct(
        public string $uuid
    ) {
    }
}
