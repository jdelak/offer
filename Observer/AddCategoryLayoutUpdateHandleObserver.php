<?php

declare(strict_types=1);
namespace Jdelak\Offer\Observer;
use Magento\Catalog\Model\Category as CategoryModel;
use Magento\Framework\Event;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Layout as Layout;
use Magento\Framework\View\Layout\ProcessorInterface as LayoutProcessor;
/**
 *  AddCategoryLayoutUpdateHandleObserver
 */
class AddCategoryLayoutUpdateHandleObserver implements ObserverInterface
{
    /**
     * Category Custom Layout Name
     *
     */
    const LAYOUT_HANDLE_NAME = 'category_custom_layout_observer';
    /**
     * @var Registry
     */
    private $registry;
    /**
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        $this->registry = $registry;
    }
    /**
     * @param EventObserver $observer
     *
     * @return void
     */
    public function execute(EventObserver $observer)
    {
        /** @var Event $event */
        $event = $observer->getEvent();
        $actionName = $event->getData('full_action_name');
        /** @var CategoryModel|null $category **/
        $category = $this->registry->registry('current_category');
        if (
            $category &&
            $actionName === 'catalog_category_view'
        ) {
            /** @var Layout $layout */
            $layout = $event->getData('layout');
            /** @var LayoutProcessor $layoutUpdate */
            $layoutUpdate = $layout->getUpdate();
            // check if Category Display Mode is "Mixed"
            if ($category->getData('display_mode') === CategoryModel::DM_MIXED) {
                $layoutUpdate->addHandle(static::LAYOUT_HANDLE_NAME);
            }
        }
    }
}