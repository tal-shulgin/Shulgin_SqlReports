<?php


namespace Shulgin\SqlReports\Api\Data;

interface QuerysInterface
{

    const QUERYS_ID = 'querys_id';
    const DESCRIPTION = 'Description';
    const QUERY = 'Query';
    const PARAMS = 'Params';


    /**
     * Get querys_id
     * @return string|null
     */
    public function getQuerysId();

    /**
     * Set querys_id
     * @param string $querysId
     * @return \Shulgin\SqlReports\Api\Data\QuerysInterface
     */
    public function setQuerysId($querysId);

    /**
     * Get Query
     * @return string|null
     */
    public function getQuery();

    /**
     * Set Query
     * @param string $query
     * @return \Shulgin\SqlReports\Api\Data\QuerysInterface
     */
    public function setQuery($query);

    /**
     * Get Params
     * @return string|null
     */
    public function getParams();

    /**
     * Set Params
     * @param string $params
     * @return \Shulgin\SqlReports\Api\Data\QuerysInterface
     */
    public function setParams($params);

    /**
     * Get Description
     * @return string|null
     */
    public function getDescription();

    /**
     * Set Description
     * @param string $description
     * @return \Shulgin\SqlReports\Api\Data\QuerysInterface
     */
    public function setDescription($description);
}
