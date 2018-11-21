<?php

namespace Shulgin\SqlReports\Controller\Adminhtml;
/**
 * Class Querys
 * @package Shulgin\SqlReports\Controller\Adminhtml
 */
abstract class Querys extends \Magento\Backend\App\Action
{

    protected $_coreRegistry;
    const ADMIN_RESOURCE = 'Shulgin_SqlReports::top_level';

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry
    ) {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    /**
     * Init page
     *
     * @param \Magento\Backend\Model\View\Result\Page $resultPage
     * @return $resultPage
     */
    public function initPage($resultPage)
    {
        $resultPage->setActiveMenu(self::ADMIN_RESOURCE)
            ->addBreadcrumb(__('Shulgin'), __('Shulgin'))
            ->addBreadcrumb(__('Querys'), __('Querys'));
        return $resultPage;
    }
}
