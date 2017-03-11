<?php

/**
 * Modulismo_Ranger extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 *
 *
 * @category       Modulismo
 * @package        Modulismo_Ranger
 * @author         Alex Hall
 * @copyright      Copyright (c) 2017
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
class Modulismo_Ranger_Block_Index extends Mage_Catalog_Block_Product_List {

    protected $_productCollection;

    /**
     * 
     * this is a useful method inherited from Mage_Catalog_Block_Product_List
     * trying to avoid remaking wheels because that's bad, I guess.
     * 
     * @return Varien_Data_Collection
     */
    protected function _getProductCollection() {
        if (is_null($this->_productCollection)) {
            $collection = Mage::getModel('catalog/product')
                    ->getCollection()
                    ->addAttributeToFilter('price', $this->getData('range'))
                    ->setPageSize(10)
                    ->setCurPage(1);
            if($this->getRequest()->getParam('order') && $this->getRequest()->getParam('dir')){
                $collection->setOrder($this->getRequest()->getParam('order'), $this->getRequest()->getParam('dir'));
            }else{
                $collection->setOrder('price', 'asc');
            }
            
            Mage::getModel('catalog/layer')->prepareProductCollection($collection);
            $this->_productCollection = $collection;
        }
        return $this->_productCollection;
    }

}
