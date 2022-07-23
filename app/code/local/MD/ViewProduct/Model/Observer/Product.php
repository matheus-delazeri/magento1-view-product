<?php

class MD_ViewProduct_Model_Observer_Product
{
    public function addButton()
    {
        $layout = Mage::app()->getLayout();
        $productEditBlock = $layout->getBlock('product_edit');
        $saveAndContinueButton = $productEditBlock->getChild('save_and_edit_button');

        $myButton = $layout->createBlock('adminhtml/widget_button')
            ->setData(array(
                'label' => Mage::helper('viewproduct')->BUTTON_LABEL,
                'onclick' => 'setLocation(\'' . $this->getButtonUrl() . '\')',
                'class' => 'show-hide'
            ));

        $container = $layout->createBlock('core/text_list', 'button_container');
        $container->append($saveAndContinueButton);
        $container->append($myButton);

        $productEditBlock->setChild('save_and_edit_button', $container);
    }

    public function getButtonUrl()
    {
        return Mage::getModel('adminhtml/url')->getUrl('*/view/product', array(
            '_current' => true,
            'active_tab' => null
        ));
    }

    public function addColumn(Varien_Event_Observer $observer)
    {
        $block = $observer->getBlock();
        if (!isset($block)) return;

        if ($block->getType() == 'adminhtml/catalog_product_grid') {
            $block->addColumn('view_product', array(
                'header' => Mage::helper('viewproduct')->GRID_COLUMN_LABEL,
                'type'   => 'action',
                'width'  => '70px',
                'getter' => 'getId',
                'actions'   => [
                    [
                        'caption' => Mage::helper('viewproduct')->BUTTON_LABEL,
                        'url' => [
                            'base' => '*/view/product',
                        ],
                        'field' => 'id'
                    ]
                ],
                'filter'    => false,
                'sortable'  => false,
            ));
        }
    }
}