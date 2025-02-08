<?php

/**
 * Easy FAQ management
 *
 * @category   LCB
 * @package    LCB_Faq
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_Faq_Block_Adminhtml_Faq_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId("faqGrid");
        $this->setDefaultSort("id");
        $this->setDefaultDir("DESC");
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel("faq/faq")->getCollection();
        $collection->getSelect()->order('position ASC');
        $this->setCollection($collection);
        parent::_prepareCollection();
        foreach ($collection as $link) {
            if ($link->getStoreId() && $link->getStoreId() != 0) {
                $link->setStoreId(explode(',', $link->getStoreId()));
            } else {
                $link->setStoreId(array('0'));
            }
        }
        return $this;
    }

    protected function _filterStoreCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
        $this->getCollection()->addStoreFilter($value);
    }

    protected function _prepareColumns()
    {
        $this->addColumn("id", array(
            "header" => Mage::helper("faq")->__("ID"),
            "align" => "right",
            "width" => "50px",
            "type" => "number",
            "index" => "id",
        ));

        $this->addColumn("question", array(
            "header" => Mage::helper("faq")->__("Question"),
            "index" => "question",
        ));

        $this->addColumn("answer", array(
            "header" => Mage::helper("faq")->__("Answer"),
            "index" => "answer",
        ));

        $this->addColumn('category', array(
            'header' => Mage::helper('faq')->__('Category'),
            'index' => 'category',
            'type' => 'options',
            'options' => Mage::getSingleton('faq/system_config_category')->toOptionArray(),
        ));

        $this->addColumn("position", array(
            "header" => Mage::helper("faq")->__("Position"),
            "type" => "number",
            "index" => "position",
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header' => Mage::helper('faq')->__('Store View'),
                'index' => 'store_id',
                'type' => 'store',
                'store_all' => true,
                'store_view' => true,
                'sortable' => true,
                'filter_condition_callback' => array($this, '_filterStoreCondition'),
            ));
        }

        $this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl("*/*/edit", array("id" => $row->getId()));
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('ids');
        $this->getMassactionBlock()->setUseSelectAll(true);
        $this->getMassactionBlock()->addItem('remove_faq', array(
            'label' => Mage::helper('faq')->__('Remove'),
            'url' => $this->getUrl('*/adminhtml_faq/massRemove'),
            'confirm' => Mage::helper('faq')->__('Are you sure?'),
        ));
        return $this;
    }
}
