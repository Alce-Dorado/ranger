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

class Modulismo_Ranger_Block_Toolbar extends Mage_Catalog_Block_Product_List_Toolbar{

    /**
     *
     * these two variables hold our range for the toolbar
     */
    protected $from;
    protected $to;
    
    /**
     * Makes sense to use my own toolbar because i can add custom functionality later on.
     * 
     */
    protected function _construct()
    {
        parent::_construct();
        $this->from = $this->getRequest()->getParam('low');
        $this->to = $this->getRequest()->getParam('high');
    }

    /**
     * used to get custom urls, if I use the default one, things break... badly
     * 
     * @param type $mode
     * @return type
     */
    public function getModeUrl($mode)
    {
        return $this->getUrl('ranger', array($this->getModeVarName()=>$mode, 'low' => $this->from, 'high' => $this->to, $this->getPageVarName() => null));
    }
    
    /**
     * used to get custom urls, if I use the default one, things break... badly
     * 
     * @param type $order
     * @param type $direction
     * @return type
     */
    public function getOrderUrl($order, $direction)
    {
        if (is_null($order)) {
            $order = $this->getCurrentOrder() ? $this->getCurrentOrder() : $this->_availableOrder[0];
        }
        return $this->getUrl('ranger',array(
            $this->getOrderVarName()=>$order,
            $this->getDirectionVarName()=>$direction,
            'low' => $this->from, 'high' => $this->to,
            $this->getPageVarName() => null
        ));
    }
}