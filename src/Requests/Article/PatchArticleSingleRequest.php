<?php

/**
 * User: Henny Krijnen
 * Date: 08-03-22 14:54
 * Copyright (c) eWarehousing Solutions
 */

namespace MiddlewareConnector\Requests\Article;

use Sammyjo20\Saloon\Constants\Saloon;
use Sammyjo20\Saloon\Http\SaloonRequest;
use Sammyjo20\Saloon\Traits\Plugins\HasJsonBody;

class PatchArticleSingleRequest extends SaloonRequest
{
    use HasJsonBody;

    protected ?string $method = Saloon::PATCH;

    public function defineEndpoint(): string
    {
        return 'wms/articles/' . $this->uuid;
    }

    public function __construct(
        public string $uuid
    ) {
    }
}
