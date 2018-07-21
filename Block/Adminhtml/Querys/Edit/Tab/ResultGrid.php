<?php
/**
 * Class Shulgin\SqlReports\Block\Adminhtml\Querys\Edit\Tab\ResultGrid
 */

namespace Shulgin\SqlReports\Block\Adminhtml\Querys\Edit\Tab;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\App\ObjectManager;

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

    /**
     * @var Json
     */
    private $serializer;

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
        Json $serializer = null,
        array $data = []
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->_resource = $resource;
        $this->_collectionFactory = $collectionFactory;
        $this->_querysRepository = $querysRepository;
        $this->messageManager = $messageManager;
        $this->serializer = $serializer ?: ObjectManager::getInstance()->get(Json::class);
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
        $sqlParams = $data->getParams();

        if(isset($sqlParams) && !empty($sqlParams)) {
            $sqlParams = $this->serializer->unserialize($sqlParams, true);
            $sqlParams = $sqlParams['Params'];
        } else {
            $sqlParams = [];
        }

        foreach($sqlParams as $key => $param) {
            $sqlQuery  = str_replace('@'. $param['name']. ';', $param['value'], $sqlQuery);
        }

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
                //$varienObject = new \Magento\Framework\Data\Collection();
                $varienObject->setData($item);
                $collection->addItem($varienObject);
            }

            if(isset($result[0])) {
                $this->_columnsGrid = array_keys($result[0]);
            }

            $this->_queryCollection = $collection;
            $this->setCollection($this->_queryCollection);
        }
    }

    /**
     * Initialize child blocks
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        //$this->getLayout()->unsetChild('reset_filter_button');
        //$this->getLayout()->unsetChild('search_button');
        return $this;//parent::_prepareLayout();;
    }

    /**
     * Prepare collection for grid
     *
     * @return $this
     */
    protected function _prepareCollection()
    {
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

        $this->addExportType('*/*/ExportDownloadsCsv', __('CSV'));
        //$this->addExportType('*/*/exportXml', __('Excel XML'));
        return parent::_prepareColumns();
    }

    /**
     * Gets grid url
     *
     * @return string
     */
    public function getGridUrl()
    {
        //return $this->getUrl('sales_rule/*/couponsGrid', ['_current' => true]);
        return '';
    }

    /**
     *  Gets grid columns names.
     *  @return array
     */
    public function getHeaders()
    {
        return $this->_columnsGrid;
    }

    /**
     * Gets querty collection.
     * 
     * @return collection
     */
    public function getCollection()
    {
        return parent::getCollection();
    }
}