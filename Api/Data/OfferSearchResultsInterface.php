<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Jdelak\Offer\Api\Data;

interface OfferSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Offer list.
     * @return \Jdelak\Offer\Api\Data\OfferInterface[]
     */
    public function getItems();

    /**
     * Set offer_id list.
     * @param \Jdelak\Offer\Api\Data\OfferInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

