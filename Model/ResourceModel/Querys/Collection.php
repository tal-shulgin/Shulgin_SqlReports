<?php


namespace Shulgin\SqlReports\Model\ResourceModel\Querys;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            'Shulgin\SqlReports\Model\Querys',
            'Shulgin\SqlReports\Model\ResourceModel\Querys'
        );
    }
}
