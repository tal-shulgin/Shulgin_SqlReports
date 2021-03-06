<?php

namespace Shulgin\SqlReports\Controller\Adminhtml\Querys;
use Shulgin\AdvancedLogger\Logger\Logger;

class Edit extends \Shulgin\SqlReports\Controller\Adminhtml\Querys
{

    protected $resultPageFactory;
    protected $_logger;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        Logger $logger
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_logger = $logger;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('querys_id');
        $model = $this->_objectManager->create('Shulgin\SqlReports\Model\Querys');
        
        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Query no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->_coreRegistry->register('shulgin_sqlreports_querys', $model);

        // 3. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Query') : __('New Query'),
            $id ? __('Edit Query') : __('New Query')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Query'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? $model->getTitle() : __('New Query'));
        return $resultPage;
    }
}
