<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Jdelak\Offer\Model;

use Jdelak\Offer\Api\Data\OfferInterface;
use Jdelak\Offer\Api\Data\OfferInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;

class Offer extends \Magento\Framework\Model\AbstractModel
{

    protected $offerDataFactory;

    protected $_eventPrefix = 'jdelak_offer_offer';
    protected $dataObjectHelper;


    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param OfferInterfaceFactory $offerDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \Jdelak\Offer\Model\ResourceModel\Offer $resource
     * @param \Jdelak\Offer\Model\ResourceModel\Offer\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        OfferInterfaceFactory $offerDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Jdelak\Offer\Model\ResourceModel\Offer $resource,
        \Jdelak\Offer\Model\ResourceModel\Offer\Collection $resourceCollection,
        array $data = []
    ) {
        $this->offerDataFactory = $offerDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve offer model with offer data
     * @return OfferInterface
     */
    public function getDataModel()
    {
        $offerData = $this->getData();
        
        $offerDataObject = $this->offerDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $offerDataObject,
            $offerData,
            OfferInterface::class
        );
        
        return $offerDataObject;
    }
}

