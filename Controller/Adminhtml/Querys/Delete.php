<?php


namespace Shulgin\SqlReports\Controller\Adminhtml\Querys;

class Delete extends \Shulgin\SqlReports\Controller\Adminhtml\Querys
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
        $id = $this->getRequest()->getParam('querys_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->_objectManager->create('Shulgin\SqlReports\Model\Querys');
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Query.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['querys_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Query to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
