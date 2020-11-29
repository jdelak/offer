<?php

namespace Jdelak\Offer\Setup;

use \Magento\Framework\Setup\InstallSchemaInterface;
use \Magento\Framework\Setup\ModuleContextInterface;
use \Magento\Framework\Setup\SchemaSetupInterface;
use \Magento\Framework\DB\Ddl\Table;

/**
 * Class InstallSchema
 *
 * @package Jdelak\Offer\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * Install Offer and Offer_Category tables
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();


        if ($setup->getConnection()->isTableExists('jdelak_offer_offer') != true) {
            $table = $setup->getConnection()
                ->newTable('jdelak_offer_offer')
                ->addColumn(
                    'offer_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    'label',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Label'
                )
                ->addColumn(
                    'image',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Image'
                )
                ->addColumn(
                    'redirect_link',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Redirect_link'
                )
                ->addColumn(
                    'starting_date',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                    'Starting At'
                )
                ->addColumn(
                    'ending_date',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                    'Ending At'
                )
                ->setComment('JDelak Offer - Offer');
            $setup->getConnection()->createTable($table);
        }

        if ($setup->getConnection()->isTableExists('jdelak_offer_offer_category') != true) {
            $table = $setup->getConnection()
                ->newTable('jdelak_offer_offer_category')
                ->addColumn(
                    'offer_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    ['unsigned'=> true, 'nullable' => false, 'primary' => true],
                    'Offer ID'
                )->addColumn(
                    'category_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    ['unsigned' => true, 'nullable' => false, 'primary' => true],
                    'Category ID'
                )
                ->addForeignKey(
                    $setup->getFkName('jdelak_offer_offer_category', 'offer_id', 'jdelak_offer_offer', 'offer_id'),
                    'offer_id',
                    $setup->getTable('jdelak_offer_offer'),
                    'offer_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                )->addForeignKey(
                    $setup->getFkName('jdelak_offer_offer_category', 'category_id', 'catalog_category_entity', 'entity_id'),
                    'category_id',
                    $setup->getTable('catalog_category_entity'),
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                )->setComment(
                    'JDelak Offer link offer and category table'
                );
            $setup->getConnection()->createTable($table);
        }


        $setup->endSetup();
    }
}