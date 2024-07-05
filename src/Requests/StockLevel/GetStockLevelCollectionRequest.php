<?php

/**
 * User: Henny Krijnen
 * Date: 08-03-22 11:49
 * Copyright (c) eWarehousing Solutions
 */

namespace MiddlewareConnector\Requests\StockLevel;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\Paginatable;

class GetStockLevelCollectionRequest extends Request implements Paginatable
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return 'wms/stock';
    }
}
