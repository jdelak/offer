<?php

namespace Jdelak\Offer\Block;

use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use Jdelak\Offer\Model\ResourceModel\Offer\CollectionFactory as OfferCollectionFactory;
use DateTime;

class Banner extends Template
{
    /**
     * CollectionFactory
     * @var null|CollectionFactory
     */
    protected $_offerCollectionFactory = null;

    protected $registry;


    /**
     * Constructor
     *
     * @param Context $context
     * @param OfferCollectionFactory $offerCollectionFactory
     * @param ResourceOffer $resource
     * @param array $data
     */
    public function __construct(
        Context $context,
        OfferCollectionFactory $offerCollectionFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->_offerCollectionFactory = $offerCollectionFactory;
        $this->registry = $registry;
        $this->_storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    public function getBanners(){
        
        $categoryId = $this->getCurrentCategory()->getId();
        return $this->getBannersfromCategory($categoryId);
    }
    
   
    public function getBannersfromCategory($category_id){
        
        $table = $this->getTableName('jdelak_offer_offer');
        $categoryTable = $this->getTableName('catalog_category_entity');
        $offerCategoryTable = $this->getTableName('jdelak_offer_offer_category');
        $date = new DateTime();
        $formatedDate = date_format($date, 'Y-m-d H:i:s');
        /* Ne marche pas pour le moment à cause de duplicate ID en cas d'une offre associé à plusieurs catégories */
        // $collection = $this->_offerCollectionFactory->create();
        // $collection->addFieldToSelect(array('label','image','redirect_link','starting_date','ending_date'))
        //             ->getSelect()
        //             ->joinLeft(
        //                 ['oct'=>$offerCategoryTable],
        //                 "main_table.offer_id = oct.offer_id"
        //             )
        //             ->where('oct.category_id', $category_id)
        //             ->where ('ending_date', array('gt' => date_format($date, 'Y-m-d H:i:s')))
        // ;
        // return $collection;


        $resourceConnection  = \Magento\Framework\App\ObjectManager::getInstance()
        ->get('Magento\Framework\App\ResourceConnection');
        /* Create Connection */
        $connection  = $resourceConnection->getConnection();
        $sql = 'SELECT of.label, of.image, of.redirect_link, of.starting_date, of.ending_date, ofc.category_id FROM '.$table.
        ' of LEFT JOIN '.$offerCategoryTable.' ofc ON of.offer_id = ofc.offer_id WHERE ofc.category_id = '.$category_id.' AND ending_date >= "'.$formatedDate.'"';
        $banners = $connection->query($sql);
        return $banners;
    }

    public function getCurrentCategory()
    {      
        return $this->registry->registry('current_category');
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

    public function getMediaPath(){
        $mediapath = $this ->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA ).'offer/tmp/image/';
        return $mediapath;
    }

}
