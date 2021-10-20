<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductAlternativeProductLabelConnector;

use Spryker\Zed\Kernel\AbstractBundleConfig;

class ProductAlternativeProductLabelConnectorConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    protected const PRODUCT_ALTERNATIVES_LABEL_NAME = 'Alternatives available';

    /**
     * @var string
     */
    protected const PRODUCT_ALTERNATIVES_LABEL_FRONT_END_REFERENCE = 'alternatives';

    /**
     * @var int
     */
    protected const PRODUCT_LABEL_DEFAULT_POSITION = 0;

    /**
     * Specification:
     * - Returns product alternatives label.
     *
     * @api
     *
     * @return string
     */
    public function getProductAlternativesLabelName(): string
    {
        return static::PRODUCT_ALTERNATIVES_LABEL_NAME;
    }

    /**
     * Specification:
     * - Returns frontend reference of product alternatives label.
     *
     * @api
     *
     * @return string
     */
    public function getProductAlternativesLabelFrontEndReference(): string
    {
        return static::PRODUCT_ALTERNATIVES_LABEL_FRONT_END_REFERENCE;
    }

    /**
     * Specification:
     * - Returns default position for product label.
     *
     * @api
     *
     * @return int
     */
    public function getProductLabelDefaultPosition(): int
    {
        return static::PRODUCT_LABEL_DEFAULT_POSITION;
    }
}
