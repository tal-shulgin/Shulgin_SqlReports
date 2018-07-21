<?php


namespace Shulgin\SqlReports\Model\Querys;

use Magento\Framework\App\Request\DataPersistorInterface;
use Shulgin\SqlReports\Model\ResourceModel\Querys\CollectionFactory;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\App\ObjectManager;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    protected $loadedData;
    protected $collection;
    protected $dataPersistor;

    /**
     * @var Json
     */
    private $serializer;


    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        Json $serializer = null,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->serializer = $serializer ?: ObjectManager::getInstance()->get(Json::class);
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();

        foreach ($items as $model) {
            $data = $model->getData();

            if(isset($data['Params']) && !empty($data['Params'])) {
                $data['Params'] = $this->serializer->unserialize($data['Params']);
            }

            $this->loadedData[$model->getId()] = $data;
        }

        $data = $this->dataPersistor->get('shulgin_sqlreports_querys');

        if (!empty($data)) 
        {
            $model = $this->collection->getNewEmptyItem();

            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('shulgin_sqlreports_querys');
        }
        
        return $this->loadedData;
    }
}
