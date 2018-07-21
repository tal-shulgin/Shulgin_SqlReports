<?php


namespace Shulgin\SqlReports\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{

    /**
     * {@inheritdoc}
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;
        $installer->startSetup();

        $table_shulgin_sqlreports_querys = $setup->getConnection()->newTable($setup->getTable('shulgin_sqlreports_querys'));

        
        $table_shulgin_sqlreports_querys->addColumn(
            'querys_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            array('identity' => true,'nullable' => false,'primary' => true,'unsigned' => true,),
            'Entity ID'
        );
        

        
        $table_shulgin_sqlreports_querys->addColumn(
            'Query',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Query String'
        );
        

        
        $table_shulgin_sqlreports_querys->addColumn(
            'Params',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Params'
        );
        

        
        $table_shulgin_sqlreports_querys->addColumn(
            'Description',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Description '
        );
        

        $setup->getConnection()->createTable($table_shulgin_sqlreports_querys);

        $setup->endSetup();
    }
}
