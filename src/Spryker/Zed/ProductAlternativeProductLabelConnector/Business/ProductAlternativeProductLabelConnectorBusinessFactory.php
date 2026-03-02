<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductAlternativeProductLabelConnector\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\ProductAlternativeProductLabelConnector\Business\Installer\ProductAlternativeProductLabelConnectorInstaller;
use Spryker\Zed\ProductAlternativeProductLabelConnector\Business\Installer\ProductAlternativeProductLabelConnectorInstallerInterface;
use Spryker\Zed\ProductAlternativeProductLabelConnector\Business\ProductAlternativeProductLabelReader\ProductAbstractRelationReader;
use Spryker\Zed\ProductAlternativeProductLabelConnector\Business\ProductAlternativeProductLabelReader\ProductAbstractRelationReaderInterface;
use Spryker\Zed\ProductAlternativeProductLabelConnector\Business\ProductAlternativeProductLabelWriter\ProductAlternativeProductLabelWriter;
use Spryker\Zed\ProductAlternativeProductLabelConnector\Business\ProductAlternativeProductLabelWriter\ProductAlternativeProductLabelWriterInterface;
use Spryker\Zed\ProductAlternativeProductLabelConnector\Dependency\Facade\ProductAlternativeProductLabelConnectorToLocaleFacadeInterface;
use Spryker\Zed\ProductAlternativeProductLabelConnector\Dependency\Facade\ProductAlternativeProductLabelConnectorToProductAlternativeFacadeInterface;
use Spryker\Zed\ProductAlternativeProductLabelConnector\Dependency\Facade\ProductAlternativeProductLabelConnectorToProductInterface;
use Spryker\Zed\ProductAlternativeProductLabelConnector\Dependency\Facade\ProductAlternativeProductLabelConnectorToProductLabelFacadeInterface;
use Spryker\Zed\ProductAlternativeProductLabelConnector\Dependency\Facade\ProductAlternativeProductLabelConnectorToStoreFacadeInterface;
use Spryker\Zed\ProductAlternativeProductLabelConnector\ProductAlternativeProductLabelConnectorDependencyProvider;

/**
 * @method \Spryker\Zed\ProductAlternativeProductLabelConnector\ProductAlternativeProductLabelConnectorConfig getConfig()
 */
class ProductAlternativeProductLabelConnectorBusinessFactory extends AbstractBusinessFactory
{
    public function createProductAlternativeProductLabelConnectorInstaller(): ProductAlternativeProductLabelConnectorInstallerInterface
    {
        return new ProductAlternativeProductLabelConnectorInstaller(
            $this->getConfig(),
            $this->getProductLabelFacade(),
            $this->getLocaleFacade(),
            $this->getStoreFacade(),
        );
    }

    public function createProductAlternativeProductLabelWriter(): ProductAlternativeProductLabelWriterInterface
    {
        return new ProductAlternativeProductLabelWriter(
            $this->getProductFacade(),
            $this->getProductLabelFacade(),
            $this->getProductAlternativeFacade(),
            $this->getConfig(),
        );
    }

    public function createProductAbstractRelationReader(): ProductAbstractRelationReaderInterface
    {
        return new ProductAbstractRelationReader(
            $this->getProductFacade(),
            $this->getProductLabelFacade(),
            $this->getProductAlternativeFacade(),
            $this->getConfig(),
        );
    }

    public function getProductLabelFacade(): ProductAlternativeProductLabelConnectorToProductLabelFacadeInterface
    {
        return $this->getProvidedDependency(ProductAlternativeProductLabelConnectorDependencyProvider::FACADE_PRODUCT_LABEL);
    }

    public function getProductFacade(): ProductAlternativeProductLabelConnectorToProductInterface
    {
        return $this->getProvidedDependency(ProductAlternativeProductLabelConnectorDependencyProvider::FACADE_PRODUCT);
    }

    public function getProductAlternativeFacade(): ProductAlternativeProductLabelConnectorToProductAlternativeFacadeInterface
    {
        return $this->getProvidedDependency(ProductAlternativeProductLabelConnectorDependencyProvider::FACADE_PRODUCT_ALTERNATIVE);
    }

    public function getLocaleFacade(): ProductAlternativeProductLabelConnectorToLocaleFacadeInterface
    {
        return $this->getProvidedDependency(ProductAlternativeProductLabelConnectorDependencyProvider::FACADE_LOCALE);
    }

    public function getStoreFacade(): ProductAlternativeProductLabelConnectorToStoreFacadeInterface
    {
        return $this->getProvidedDependency(ProductAlternativeProductLabelConnectorDependencyProvider::FACADE_STORE);
    }
}
