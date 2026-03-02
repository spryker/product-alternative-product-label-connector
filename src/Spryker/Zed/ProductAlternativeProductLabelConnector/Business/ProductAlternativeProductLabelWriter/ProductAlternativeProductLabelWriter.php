<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductAlternativeProductLabelConnector\Business\ProductAlternativeProductLabelWriter;

use Generated\Shared\Transfer\ProductLabelTransfer;
use Spryker\Zed\ProductAlternativeProductLabelConnector\Dependency\Facade\ProductAlternativeProductLabelConnectorToProductAlternativeFacadeInterface;
use Spryker\Zed\ProductAlternativeProductLabelConnector\Dependency\Facade\ProductAlternativeProductLabelConnectorToProductInterface;
use Spryker\Zed\ProductAlternativeProductLabelConnector\Dependency\Facade\ProductAlternativeProductLabelConnectorToProductLabelFacadeInterface;
use Spryker\Zed\ProductAlternativeProductLabelConnector\ProductAlternativeProductLabelConnectorConfig;

class ProductAlternativeProductLabelWriter implements ProductAlternativeProductLabelWriterInterface
{
    /**
     * @var \Spryker\Zed\ProductAlternativeProductLabelConnector\Dependency\Facade\ProductAlternativeProductLabelConnectorToProductInterface
     */
    protected $productFacade;

    /**
     * @var \Spryker\Zed\ProductAlternativeProductLabelConnector\Dependency\Facade\ProductAlternativeProductLabelConnectorToProductLabelFacadeInterface
     */
    protected $productLabelFacade;

    /**
     * @var \Spryker\Zed\ProductAlternativeProductLabelConnector\Dependency\Facade\ProductAlternativeProductLabelConnectorToProductAlternativeFacadeInterface
     */
    protected $productAlternativeFacade;

    /**
     * @var \Spryker\Zed\ProductAlternativeProductLabelConnector\ProductAlternativeProductLabelConnectorConfig
     */
    protected $config;

    public function __construct(
        ProductAlternativeProductLabelConnectorToProductInterface $productFacade,
        ProductAlternativeProductLabelConnectorToProductLabelFacadeInterface $productLabelFacade,
        ProductAlternativeProductLabelConnectorToProductAlternativeFacadeInterface $productAlternativeFacade,
        ProductAlternativeProductLabelConnectorConfig $config
    ) {
        $this->productFacade = $productFacade;
        $this->productLabelFacade = $productLabelFacade;
        $this->productAlternativeFacade = $productAlternativeFacade;
        $this->config = $config;
    }

    public function updateAbstractProductWithAlternativesAvailableLabel(int $idProduct): void
    {
        $productLabelTransfer = $this->findProductAlternativeProductLabel();
        $idProductAbstract = $this->productFacade->findProductAbstractIdByConcreteId($idProduct);
        if (!$productLabelTransfer || !$idProductAbstract) {
            return;
        }

        $idProductLabel = $productLabelTransfer->getIdProductLabel();
        if (!$this->isProductAlternativeLabelApplicable($idProductAbstract)) {
            $this->productLabelFacade->removeProductAbstractRelationsForLabel($idProductLabel, [$idProductAbstract]);

            return;
        }

        if (!in_array($idProductLabel, $this->productLabelFacade->findActiveLabelIdsByIdProductAbstract($idProductAbstract))) {
            $this->productLabelFacade->addAbstractProductRelationsForLabel($idProductLabel, [$idProductAbstract]);
        }
    }

    protected function isProductAlternativeLabelApplicable(int $idProductAbstract): bool
    {
        $productConcreteIds = $this->productFacade->findProductConcreteIdsByAbstractProductId($idProductAbstract);
        if (!$this->productAlternativeFacade->doAllConcreteProductsHaveAlternatives($productConcreteIds)) {
            return false;
        }

        foreach ($productConcreteIds as $idProductConcrete) {
            if (!$this->productAlternativeFacade->isAlternativeProductApplicable($idProductConcrete)) {
                return false;
            }
        }

        return true;
    }

    protected function findProductAlternativeProductLabel(): ?ProductLabelTransfer
    {
        return $this->productLabelFacade->findLabelByLabelName(
            $this->config->getProductAlternativesLabelName(),
        );
    }

    public function removeProductAbstractRelationsForLabel(int $idProduct): void
    {
        $productLabelTransfer = $this->findProductAlternativeProductLabel();
        $idProductAbstract = $this->productFacade->findProductAbstractIdByConcreteId($idProduct);
        if (!$productLabelTransfer || !$idProductAbstract) {
            return;
        }

        $this->productLabelFacade->removeProductAbstractRelationsForLabel($productLabelTransfer->getIdProductLabel(), [$idProductAbstract]);
    }
}
