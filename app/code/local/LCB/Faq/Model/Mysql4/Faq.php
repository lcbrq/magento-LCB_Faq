<?php

/**
 * Easy FAQ management
 *
 * @category   LCB
 * @package    LCB_Faq
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_Faq_Model_Mysql4_Faq extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("faq/faq", "id");
    }
}
