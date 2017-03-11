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
class Modulismo_Ranger_IndexController extends Mage_Core_Controller_Front_Action {

    #here we validate so we don't let creepers peek into account areas
    public function preDispatch()
    {
        parent::preDispatch();
        if (!Mage::getSingleton('customer/session')->authenticate($this)) {
            $this->setFlag('', 'no-dispatch', true);
        }
    }
    
    #here we load and render all the components for the 'ranger' accounts area
    public function IndexAction() {
        
        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('catalog/session');
        
        $this->getLayout()->getBlock("head")->setTitle($this->__("Ranger"));
        $this->renderLayout();
    }
    
    #here we load a bunch or zero product... depending on input, i guess.
    public function getproductsAction(){
        #sassy semi-validation takes place here
        if(($this->getRequest()->getParam('low') == null) || $this->getRequest()->getParam('high') == null){
            $this->getResponse()->setBody(Mage::helper('modulismo_ranger')->__("You're out of line, sir!"));
            return;
        }
        
        #if we have a good range, we proceed to load a block that will display our prods
        $low = $this->getRequest()->getParam('low');
        $high = $this->getRequest()->getParam('high');
        $block = $this->loadLayout()->getLayout()->getBlock('modulismo_ranger.products')->setData('range', array('from' => $low, 'to' => $high));
        $this->getResponse()->setBody($block->toHtml());
        return;
    }
}
