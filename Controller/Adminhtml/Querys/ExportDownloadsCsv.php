<?php
/**
 * Class Shulgin\SqlReports\Controller\Adminhtml\Querys\ExportDownloadsCsv
 */
namespace Shulgin\SqlReports\Controller\Adminhtml\Querys;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Filesystem\DirectoryList;

class ExportDownloadsCsv  extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Shulgin_SqlReports::top_level';

    /**
     * TODO: need to be prettify  and more elegant. 
     * Export query result downloads report to CSV format
     *
     * @return ResponseInterface
     */
    public function execute()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $directory = $objectManager->get('\Magento\Framework\Filesystem\DirectoryList');
        $base =  $directory->getRoot();
        $fileName = $base. '/'. 'products_downloads.csv';

        $content = $this->_view->getLayout()->createBlock(
            \Shulgin\SqlReports\Block\Adminhtml\Querys\Edit\Tab\ResultGrid::class
        );

        $items = $content->getCollection()->getItems();

        $fp = fopen($fileName, 'w');

        fputcsv($fp, $content->getHeaders());

        foreach ($items as $fields) {
            fputcsv($fp, $fields->toArray());
        }

        fclose($fp);

        $fileFactory = $objectManager->get('\Magento\Framework\App\Response\Http\FileFactory');
        return $fileFactory->create($fileName, file_get_contents($fileName));
    }
}
