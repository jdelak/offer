<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Jdelak\Offer\Api\Data;

interface OfferInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const REDIRECT_LINK = 'redirect_link';
    const ENDING_DATE = 'ending_date';
    const OFFER_ID = 'offer_id';
    const LABEL = 'label';
    const IMAGE = 'image';
    const STARTING_DATE = 'starting_date';

    /**
     * Get offer_id
     * @return string|null
     */
    public function getOfferId();

    /**
     * Set offer_id
     * @param string $offerId
     * @return \Jdelak\Offer\Api\Data\OfferInterface
     */
    public function setOfferId($offerId);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Jdelak\Offer\Api\Data\OfferExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Jdelak\Offer\Api\Data\OfferExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Jdelak\Offer\Api\Data\OfferExtensionInterface $extensionAttributes
    );

    /**
     * Get image
     * @return string|null
     */
    public function getImage();

    /**
     * Set image
     * @param string $image
     * @return \Jdelak\Offer\Api\Data\OfferInterface
     */
    public function setImage($image);

    /**
     * Get redirect_link
     * @return string|null
     */
    public function getRedirectLink();

    /**
     * Set redirect_link
     * @param string $redirectLink
     * @return \Jdelak\Offer\Api\Data\OfferInterface
     */
    public function setRedirectLink($redirectLink);

    /**
     * Get starting_date
     * @return string|null
     */
    public function getStartingDate();

    /**
     * Set starting_date
     * @param string $startingDate
     * @return \Jdelak\Offer\Api\Data\OfferInterface
     */
    public function setStartingDate($startingDate);

    /**
     * Get ending_date
     * @return string|null
     */
    public function getEndingDate();

    /**
     * Set ending_date
     * @param string $endingDate
     * @return \Jdelak\Offer\Api\Data\OfferInterface
     */
    public function setEndingDate($endingDate);

    /**
     * Get label
     * @return string|null
     */
    public function getLabel();

    /**
     * Set label
     * @param string $label
     * @return \Jdelak\Offer\Api\Data\OfferInterface
     */
    public function setLabel($label);
}

