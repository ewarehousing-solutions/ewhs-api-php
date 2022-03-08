<?php

/**
 * User: Henny Krijnen
 * Date: 08-03-22 14:55
 * Copyright (c) eWarehousing Solutions
 */

namespace MiddlewareConnector\Requests\Batch;

use Sammyjo20\Saloon\Constants\Saloon;
use Sammyjo20\Saloon\Http\SaloonRequest;

class GetBatchSingleRequest extends SaloonRequest
{
    protected ?string $method = Saloon::GET;

    public function defineEndpoint(): string
    {
        return 'wms/batches/' . $this->uuid;
    }

    public function __construct(
        public string $uuid
    ) {
    }
}
