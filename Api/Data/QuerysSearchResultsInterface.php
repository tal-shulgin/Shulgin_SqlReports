<?php


namespace Shulgin\SqlReports\Api\Data;

interface QuerysSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{


    /**
     * Get Querys list.
     * @return \Shulgin\SqlReports\Api\Data\QuerysInterface[]
     */
    public function getItems();

    /**
     * Set Query list.
     * @param \Shulgin\SqlReports\Api\Data\QuerysInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
