<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Jdelak\Offer\Controller\Adminhtml\Offer;

class Delete extends \Jdelak\Offer\Controller\Adminhtml\Offer
{

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('offer_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->_objectManager->create(\Jdelak\Offer\Model\Offer::class);
                $model->load($id);
                $this->removeOfferCategoriesbyOffer($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Offer.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['offer_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Offer to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
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

