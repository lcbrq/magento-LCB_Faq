<?php
/**
 * Easy FAQ management
 *
 * @category   LCB
 * @package    LCB_Faq
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 * @since      1.5.0
 */
class LCB_Faq_Controller_Router extends Mage_Core_Controller_Varien_Router_Standard
{
    /**
     * Match the request
     *
     * @param  Zend_Controller_Request_Http $request
     * @return boolean
     */
    public function match(Zend_Controller_Request_Http $request)
    {
        if (!$this->_beforeModuleMatch()) {
            return false;
        }

        $routes = Mage::helper('faq')->getCustomRoutes();
        foreach ($routes as $route) {
            if (strpos($request->getPathInfo() . '/', $route) !== false) {
                $urlKey = trim(str_replace($route, '', $request->getPathInfo()), '/');
                $request->setModuleName('faq');
                $request->setControllerName('index');
                $request->setActionName('index');
                if (!$urlKey) {
                    return true;
                }
                $qaSet = Mage::getModel('faq/faq')->getCollection()
                        ->addFieldToFilter('url_key', $urlKey)->getFirstItem();
                if ($qaSet->getId()) {
                    $request->setPathInfo("/$route/$urlKey /");
                    $request->setParam('id', $qaSet->getCategory());
                    $request->setParam('set', $qaSet->getId());
                    return true;
                }
                $qaCategory = Mage::getModel('faq/category')->getCollection()
                        ->addFieldToFilter('identifier', $urlKey)->getFirstItem();
                if ($qaCategory->getId()) {
                    $request->setPathInfo("/$route/$urlKey /");
                    $request->setParam('id', $qaCategory->getId());
                    return true;
                }
            }
        }

        return false;
    }
}
