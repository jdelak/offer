<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Jdelak\Offer\Model;

use Jdelak\Offer\Api\Data\OfferInterfaceFactory;
use Jdelak\Offer\Api\Data\OfferSearchResultsInterfaceFactory;
use Jdelak\Offer\Api\OfferRepositoryInterface;
use Jdelak\Offer\Model\ResourceModel\Offer as ResourceOffer;
use Jdelak\Offer\Model\ResourceModel\Offer\CollectionFactory as OfferCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

class OfferRepository implements OfferRepositoryInterface
{

    private $storeManager;

    protected $extensibleDataObjectConverter;
    protected $extensionAttributesJoinProcessor;

    protected $dataObjectHelper;

    private $collectionProcessor;

    protected $resource;

    protected $dataObjectProcessor;

    protected $offerFactory;

    protected $searchResultsFactory;

    protected $offerCollectionFactory;

    protected $dataOfferFactory;


    /**
     * @param ResourceOffer $resource
     * @param OfferFactory $offerFactory
     * @param OfferInterfaceFactory $dataOfferFactory
     * @param OfferCollectionFactory $offerCollectionFactory
     * @param OfferSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceOffer $resource,
        OfferFactory $offerFactory,
        OfferInterfaceFactory $dataOfferFactory,
        OfferCollectionFactory $offerCollectionFactory,
        OfferSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->offerFactory = $offerFactory;
        $this->offerCollectionFactory = $offerCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataOfferFactory = $dataOfferFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \Jdelak\Offer\Api\Data\OfferInterface $offer
    ) {
        /* if (empty($offer->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $offer->setStoreId($storeId);
        } */
        
        $offerData = $this->extensibleDataObjectConverter->toNestedArray(
            $offer,
            [],
            \Jdelak\Offer\Api\Data\OfferInterface::class
        );
        
        $offerModel = $this->offerFactory->create()->setData($offerData);
        
        try {
            $this->resource->save($offerModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the offer: %1',
                $exception->getMessage()
            ));
        }
        return $offerModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function get($offerId)
    {
        $offer = $this->offerFactory->create();
        $this->resource->load($offer, $offerId);
        if (!$offer->getId()) {
            throw new NoSuchEntityException(__('Offer with id "%1" does not exist.', $offerId));
        }
        return $offer->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->offerCollectionFactory->create();
        
        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Jdelak\Offer\Api\Data\OfferInterface::class
        );
        
        $this->collectionProcessor->process($criteria, $collection);
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        
        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }
        
        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \Jdelak\Offer\Api\Data\OfferInterface $offer
    ) {
        try {
            $offerModel = $this->offerFactory->create();
            $this->resource->load($offerModel, $offer->getOfferId());
            $this->resource->delete($offerModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Offer: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($offerId)
    {
        return $this->delete($this->get($offerId));
    }


    public function removeOfferCategories($offerId){

        $directSql = $this->_objectManager->create(\Jdelak\Offer\Model\DirectSql::class);

        $tableName = $directSql->getTableName('jdelak_offer_offer_category');
        $connection = $directSql->getConnection();
        //TODO FIND A BETTER METHOD TO DELETE MANY TO MANY
        $sql = "DELETE FROM " . $tableName . " WHERE offer_id = " .(int)$offerId;
        $connection->query($sql);
    }

}

