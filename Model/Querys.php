<?php


namespace Shulgin\SqlReports\Model;

use Shulgin\SqlReports\Api\Data\QuerysInterface;

class Querys extends \Magento\Framework\Model\AbstractModel implements QuerysInterface
{

    protected $_eventPrefix = 'shulgin_sqlreports_querys';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Shulgin\SqlReports\Model\ResourceModel\Querys');
    }

    /**
     * Get querys_id
     * @return string
     */
    public function getQuerysId()
    {
        return $this->getData(self::QUERYS_ID);
    }

    /**
     * Set querys_id
     * @param string $querysId
     * @return \Shulgin\SqlReports\Api\Data\QuerysInterface
     */
    public function setQuerysId($querysId)
    {
        return $this->setData(self::QUERYS_ID, $querysId);
    }

    /**
     * Get Query
     * @return string
     */
    public function getQuery()
    {
        return $this->getData(self::QUERY);
    }

    /**
     * Set Query
     * @param string $query
     * @return \Shulgin\SqlReports\Api\Data\QuerysInterface
     */
    public function setQuery($query)
    {
        return $this->setData(self::QUERY, $query);
    }

    /**
     * Get Params
     * @return string
     */
    public function getParams()
    {
        return $this->getData(self::PARAMS);
    }

    /**
     * Set Params
     * @param string $params
     * @return \Shulgin\SqlReports\Api\Data\QuerysInterface
     */
    public function setParams($params)
    {
        return $this->setData(self::PARAMS, $params);
    }

    /**
     * Get Description
     * @return string
     */
    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * Set Description
     * @param string $description
     * @return \Shulgin\SqlReports\Api\Data\QuerysInterface
     */
    public function setDescription($description)
    {
        return $this->setData(self::DESCRIPTION, $description);
    }
}
