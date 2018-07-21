<?php


namespace Shulgin\SqlReports\Model\ResourceModel;

class Querys extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('shulgin_sqlreports_querys', 'querys_id');
    }
}
