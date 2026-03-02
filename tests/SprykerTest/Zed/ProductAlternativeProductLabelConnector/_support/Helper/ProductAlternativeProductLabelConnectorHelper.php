<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\ProductAlternativeProductLabelConnector\Helper;

use Codeception\Module;
use Orm\Zed\ProductAlternative\Persistence\SpyProductAlternativeQuery;
use Orm\Zed\ProductLabel\Persistence\SpyProductLabelProductAbstractQuery;

class ProductAlternativeProductLabelConnectorHelper extends Module
{
    public function ensureDatabaseTableIsEmpty(): void
    {
        $query = $this->getProductLabelProductAbstractQuery();
        $query->deleteAll();
    }

    public function ensureTableProductAlternativeIsEmpty(): void
    {
        $query = $this->getProductAlternativeQuery();
        $query->deleteAll();
    }

    public function assertDatabaseTableContainsData(): void
    {
        $query = $this->getProductLabelProductAbstractQuery();
        $this->assertGreaterThan(
            0,
            $query->count(),
            'Expected at least one entry in the database table but database table is empty.',
        );
    }

    protected function getProductLabelProductAbstractQuery(): SpyProductLabelProductAbstractQuery
    {
        return SpyProductLabelProductAbstractQuery::create();
    }

    protected function getProductAlternativeQuery(): SpyProductAlternativeQuery
    {
        return SpyProductAlternativeQuery::create();
    }
}
