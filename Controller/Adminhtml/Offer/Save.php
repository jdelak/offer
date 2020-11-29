<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Jdelak\Offer\Controller\Adminhtml\Offer;

use Magento\Framework\Exception\LocalizedException;


class Save extends \Magento\Backend\App\Action
{

    protected $dataPersistor;
    protected $offerRepository;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     * @param \Magento\Framework\App\ResourceConnection $resourceConnection
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('offer_id');

            $model = $this->_objectManager->create(\Jdelak\Offer\Model\Offer::class)->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Offer no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
            $data = $this->_filterData($data);
         
            if($data['ending_date'] >= $data['starting_date']){
                $model->setData($data);
            } 
            //TODO catch error else ?

            try {

                 //remove all categories before adding only selected 
                $this->removeOfferCategoriesbyOffer($id);
                foreach($data["categories"] as $catId){
                    $this->saveOfferCategories($id, (int)$catId);
                }

                $model->save();
                
                $this->messageManager->addSuccessMessage(__('You saved the Offer.'));
                $this->dataPersistor->clear('jdelak_offer_offer');
            
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['offer_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');

            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Offer.'));
            }
        
            $this->dataPersistor->set('jdelak_offer_offer', $data);
            return $resultRedirect->setPath('*/*/edit', ['offer_id' => $this->getRequest()->getParam('offer_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    public function _filterData(array $rawData)
    {
        //Replace image with fileuploader field name
        $data = $rawData;
        if (isset($data['image'][0]['name'])) {
            $data['image'] = $data['image'][0]['name'];
        } else {
            $data['image'] = null;
        }
        return $data;
    }

    /** 
     * insert in offer_category Table
     */
    public function saveOfferCategories($offerId, $categoryId){

        $resourceConnection  = \Magento\Framework\App\ObjectManager::getInstance()
        ->get('Magento\Framework\App\ResourceConnection');
        $connection= $resourceConnection ->getConnection();
        $tableName = $this->getTableName('jdelak_offer_offer_category');
        //TODO FIND A BETTER METHOD TO HANDLE MANY TO MANY
        $sql = "Insert Into " . $tableName . " (offer_id, category_id) Values (".(int)$offerId.",".(int)$categoryId.")";
        $connection->query($sql);
        
    }

    /**
     * Get Table name using direct query
     */
    public function getTablename($tableName)
    {
        $resourceConnection  = \Magento\Framework\App\ObjectManager::getInstance()
        ->get('Magento\Framework\App\ResourceConnection');
        /* Create Connection */
        $connection  = $resourceConnection->getConnection();
        $tableName   = $connection->getTableName($tableName);
        return $tableName;
    }

    //remove many to many relation
    public function removeOfferCategoriesbyOffer($offer_id){
        $resourceConnection  = \Magento\Framework\App\ObjectManager::getInstance()
        ->get('Magento\Framework\App\ResourceConnection');
        $connection  = $resourceConnection->getConnection();
        $tableName = $connection->getTableName('jdelak_offer_offer_category');

        $sql = "DELETE FROM " . $tableName . " WHERE offer_id = ".(int)$offer_id;
        return $connection->query($sql);
    }
}

