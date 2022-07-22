<?php

class MD_ViewProduct_Adminhtml_ViewController extends Mage_Adminhtml_Controller_Action
{
    public function productAction()
    {
        $productId = $this->getRequest()->getParam('id');
        $product = Mage::getModel('catalog/product')->load($productId);
        $url = $product->getProductUrl();
        if($product->getVisibility() != Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE
           && $product->getStatus() != Mage_Catalog_Model_Product_Status::STATUS_DISABLED)
        {
            $this->_redirectUrl($url);
        } else {
            $this->_redirectReferer();
            Mage::getSingleton('core/session')->addError('Product is not visible in store');
        }
    }
}