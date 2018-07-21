<?php

namespace Shulgin\SqlReports\Setup;
use Magento\Analytics\Model\Config\Backend\Enabled\SubscriptionHandler;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    protected $_querysFactory;
 
    public function __construct(\Shulgin\SqlReports\Model\QuerysFactory $querysFactory)
    {
        $this->_querysFactory = $querysFactory;
    }
 
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        
        $data = [
            'Query' => "select * 
                        from setup_module
                        where module like '%@MODULE;%'
                        limit @LIMIT;
                        ",
            'Params' => '{"Params":[{"name":"MODULE","value":"Magen","record_id":"0","initialize":"true"},{"record_id":"1","name":"LIMIT","value":"3"}]}',
            'Description' => "test db query to grid"
        ];

        $example = $this->_querysFactory->create();
        $example->addData($data)->save();
    }
}
