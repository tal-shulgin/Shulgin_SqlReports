<?php


namespace Shulgin\SqlReports\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface QuerysRepositoryInterface
{


    /**
     * Save Querys
     * @param \Shulgin\SqlReports\Api\Data\QuerysInterface $querys
     * @return \Shulgin\SqlReports\Api\Data\QuerysInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Shulgin\SqlReports\Api\Data\QuerysInterface $querys
    );

    /**
     * Retrieve Querys
     * @param string $querysId
     * @return \Shulgin\SqlReports\Api\Data\QuerysInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($querysId);

    /**
     * Retrieve Querys matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Shulgin\SqlReports\Api\Data\QuerysSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Querys
     * @param \Shulgin\SqlReports\Api\Data\QuerysInterface $querys
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Shulgin\SqlReports\Api\Data\QuerysInterface $querys
    );

    /**
     * Delete Querys by ID
     * @param string $querysId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($querysId);
}
