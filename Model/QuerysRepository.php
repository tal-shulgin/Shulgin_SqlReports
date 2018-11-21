<?php


namespace Shulgin\SqlReports\Model;

use Magento\Framework\Api\SortOrder;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Exception\NoSuchEntityException;
use Shulgin\SqlReports\Api\QuerysRepositoryInterface;
use Shulgin\SqlReports\Api\Data\QuerysInterfaceFactory;
use Magento\Framework\Exception\CouldNotSaveException;
use Shulgin\SqlReports\Api\Data\QuerysSearchResultsInterfaceFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Shulgin\SqlReports\Model\ResourceModel\Querys as ResourceQuerys;
use Magento\Framework\Api\DataObjectHelper;
use Shulgin\SqlReports\Model\ResourceModel\Querys\CollectionFactory as QuerysCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class QuerysRepository implements QuerysRepositoryInterface
{

    protected $dataQuerysFactory;

    protected $resource;

    protected $querysCollectionFactory;

    protected $querysFactory;

    protected $dataObjectHelper;

    private $storeManager;

    protected $searchResultsFactory;

    protected $dataObjectProcessor;


    /**
     * @param ResourceQuerys $resource
     * @param QuerysFactory $querysFactory
     * @param QuerysInterfaceFactory $dataQuerysFactory
     * @param QuerysCollectionFactory $querysCollectionFactory
     * @param QuerysSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ResourceQuerys $resource,
        QuerysFactory $querysFactory,
        QuerysInterfaceFactory $dataQuerysFactory,
        QuerysCollectionFactory $querysCollectionFactory,
        QuerysSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->querysFactory = $querysFactory;
        $this->querysCollectionFactory = $querysCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataQuerysFactory = $dataQuerysFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \Shulgin\SqlReports\Api\Data\QuerysInterface $querys
    ) {
        /* if (empty($querys->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $querys->setStoreId($storeId);
        } */
        try {
            $this->resource->save($querys);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the querys: %1',
                $exception->getMessage()
            ));
        }
        return $querys;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($querysId)
    {
        $querys = $this->querysFactory->create();
        $this->resource->load($querys, $querysId);
        if (!$querys->getId()) {
            throw new NoSuchEntityException(__('Querys with id "%1" does not exist.', $querysId));
        }
        return $querys;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->querysCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            $fields = [];
            $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                if ($filter->getField() === 'store_id') {
                    $collection->addStoreFilter($filter->getValue(), false);
                    continue;
                }
                $fields[] = $filter->getField();
                $condition = $filter->getConditionType() ?: 'eq';
                $conditions[] = [$condition => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }
        
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setTotalCount($collection->getSize());
        $searchResults->setItems($collection->getItems());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \Shulgin\SqlReports\Api\Data\QuerysInterface $querys
    ) {
        try {
            $this->resource->delete($querys);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Querys: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($querysId)
    {
        return $this->delete($this->getById($querysId));
    }
}
