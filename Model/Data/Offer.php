<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Jdelak\Offer\Model\Data;

use Jdelak\Offer\Api\Data\OfferInterface;

class Offer extends \Magento\Framework\Api\AbstractExtensibleObject implements OfferInterface
{

    /**
     * Get offer_id
     * @return string|null
     */
    public function getOfferId()
    {
        return $this->_get(self::OFFER_ID);
    }

    /**
     * Set offer_id
     * @param string $offerId
     * @return \Jdelak\Offer\Api\Data\OfferInterface
     */
    public function setOfferId($offerId)
    {
        return $this->setData(self::OFFER_ID, $offerId);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Jdelak\Offer\Api\Data\OfferExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Jdelak\Offer\Api\Data\OfferExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Jdelak\Offer\Api\Data\OfferExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get image
     * @return string|null
     */
    public function getImage()
    {
        return $this->_get(self::IMAGE);
    }

    /**
     * Set image
     * @param string $image
     * @return \Jdelak\Offer\Api\Data\OfferInterface
     */
    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
    }

    /**
     * Get redirect_link
     * @return string|null
     */
    public function getRedirectLink()
    {
        return $this->_get(self::REDIRECT_LINK);
    }

    /**
     * Set redirect_link
     * @param string $redirectLink
     * @return \Jdelak\Offer\Api\Data\OfferInterface
     */
    public function setRedirectLink($redirectLink)
    {
        return $this->setData(self::REDIRECT_LINK, $redirectLink);
    }

    /**
     * Get starting_date
     * @return string|null
     */
    public function getStartingDate()
    {
        return $this->_get(self::STARTING_DATE);
    }

    /**
     * Set starting_date
     * @param string $startingDate
     * @return \Jdelak\Offer\Api\Data\OfferInterface
     */
    public function setStartingDate($startingDate)
    {
        return $this->setData(self::STARTING_DATE, $startingDate);
    }

    /**
     * Get ending_date
     * @return string|null
     */
    public function getEndingDate()
    {
        return $this->_get(self::ENDING_DATE);
    }

    /**
     * Set ending_date
     * @param string $endingDate
     * @return \Jdelak\Offer\Api\Data\OfferInterface
     */
    public function setEndingDate($endingDate)
    {
        return $this->setData(self::ENDING_DATE, $endingDate);
    }

    /**
     * Get label
     * @return string|null
     */
    public function getLabel()
    {
        return $this->_get(self::LABEL);
    }

    /**
     * Set label
     * @param string $label
     * @return \Jdelak\Offer\Api\Data\OfferInterface
     */
    public function setLabel($label)
    {
        return $this->setData(self::LABEL, $label);
    }
}

