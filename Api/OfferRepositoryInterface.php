<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Jdelak\Offer\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface OfferRepositoryInterface
{

    /**
     * Save Offer
     * @param \Jdelak\Offer\Api\Data\OfferInterface $offer
     * @return \Jdelak\Offer\Api\Data\OfferInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Jdelak\Offer\Api\Data\OfferInterface $offer
    );

    /**
     * Retrieve Offer
     * @param string $offerId
     * @return \Jdelak\Offer\Api\Data\OfferInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($offerId);

    /**
     * Retrieve Offer matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Jdelak\Offer\Api\Data\OfferSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Offer
     * @param \Jdelak\Offer\Api\Data\OfferInterface $offer
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Jdelak\Offer\Api\Data\OfferInterface $offer
    );

    /**
     * Delete Offer by ID
     * @param string $offerId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($offerId);
    
}

