<?php
/**
 * ResultGrid
 *
 * @copyright Copyright © 2018 Staempfli AG. All rights reserved.
 * @author    juan.alonso@staempfli.com
 */

namespace Shulgin\SqlReports\Block\Adminhtml\Querys\Edit\Tab;

class ResultGrid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    protected $_queryId = null;
    protected $_resource = null;
    protected $_columnsGrid = [];
    protected $_collectionFactory = null;
    protected $_querysRepository = null;
    protected $_queryCollection = null;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Framework\Registry $coreRegistry,
        \Shulgin\SqlReports\Model\QuerysRepository $querysRepository,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Framework\Data\CollectionFactory $collectionFactory,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        array $data = []
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->_resource = $resource;
        $this->_collectionFactory = $collectionFactory;
        $this->_querysRepository = $querysRepository;
        $this->messageManager = $messageManager;
        $this->_queryId = $context->getRequest()->getParam('querys_id');
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('querysResualts');
        $this->setUseAjax(true);

        $data = $this->_querysRepository->getById($this->_queryId);
        $connection = $this->_resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);
        $sqlQuery = $data->getQuery();
        //$sqlParams = str_split('\r\n', $data->getParams());

  /*      if(!empty($data->getParams())) {
            $sqlParams = explode('\r\n', $data->getParams());
            if(is_array($sqlParams)) {
                //var_dump(__LINE__);
                foreach ($sqlParams as $param) {
                    //var_dump(__LINE__, $param);
                    $paramData = explode('=', $param);

                    if(!(isset($paramData[0]) && isset($paramData[1]))) {
                        continue;
                    }
                    //var_dump(__LINE__);
                    $sqlQuery  = str_replace($paramData[0].';', $paramData[1], $sqlQuery);
                }
            }
        } */

//var_dump($sqlQuery);
        try {
            $result = $connection->fetchAll($sqlQuery);
        } catch( \Exception $e) {
            $this->_queryCollection = [];
            $this->messageManager->addError($e->getMessage());
        }

        

        if(!empty($result)) {
            $collection = $this->_collectionFactory->create();

            foreach ($result as $item) {
                $varienObject = new \Magento\Framework\DataObject();
                $varienObject->setData($item);
                $collection->addItem($varienObject);
            }

            if(isset($result[0])) {
                $this->_columnsGrid = array_keys($result[0]);
            }

            $this->_queryCollection = $collection;
        }
    }

    /**
     * Prepare collection for grid
     *
     * @return $this
     */
    protected function _prepareCollection()
    {
        $this->setCollection($this->_queryCollection);
        return parent::_prepareCollection();
    }

    /**
     * Define grid columns
     *
     * @return $this
     */
    protected function _prepareColumns()
    {
        foreach ($this->_columnsGrid as $column)
        {
            $this->addColumn($column, ['header' => __($column), 'index' => $column]);
        }

        $this->addExportType('*/*/exportCouponsCsv', __('CSV'));
        $this->addExportType('*/*/exportCouponsXml', __('Excel XML'));
        return parent::_prepareColumns();
    }

    /**
     * Get grid url
     *
     * @return string
     */
    public function getGridUrl()
    {
        //return $this->getUrl('sales_rule/*/couponsGrid', ['_current' => true]);
        return '';
    }
}