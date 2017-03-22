<?php

/**
 * Easy FAQ management
 *
 * @category   LCB
 * @package    LCB_Faq
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_Faq_Helper_Data extends Mage_Core_Helper_Abstract {
    
    /**
     * Slugify string
     * @return string
     */
    public function makeSlug($string){
        return Mage::getModel('catalog/product_url')->formatUrlKey($string);
    }
}
