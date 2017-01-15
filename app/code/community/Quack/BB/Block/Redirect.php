<?php
/**
 * Este arquivo é parte do programa Quack BB
 *
 * Quack BB é um software livre; você pode redistribuí-lo e/ou
 * modificá-lo dentro dos termos da Licença Pública Geral GNU como
 * publicada pela Fundação do Software Livre (FSF); na versão 3 da
 * Licença, ou (na sua opinião) qualquer versão.
 *
 * Este programa é distribuído na esperança de que possa ser  útil,
 * mas SEM NENHUMA GARANTIA; sem uma garantia implícita de ADEQUAÇÃO
 * a qualquer MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a
 * Licença Pública Geral GNU para maiores detalhes.
 *
 * Você deve ter recebido uma cópia da Licença Pública Geral GNU junto
 * com este programa, Se não, veja <http://www.gnu.org/licenses/>.
 *
 * @category   Quack
 * @package    Quack_BB
 * @author     Rafael Patro <rafaelpatro@gmail.com>
 * @copyright  Copyright (c) 2015 Rafael Patro (rafaelpatro@gmail.com)
 * @license    http://www.gnu.org/licenses/gpl.txt
 * @link       https://github.com/rafaelpatro/Quack_BB
 */

class Quack_BB_Block_Redirect extends Mage_Core_Block_Template {

    /**
     * (non-PHPdoc)
     * @see Mage_Core_Block_Abstract::_construct()
     */
    protected function _construct() {
        parent::_construct();
        $this->setTemplate('bb/redirect.phtml');
    }
    
    /**
     * (non-PHPdoc)
     * @see Mage_Core_Block_Abstract::_beforeToHtml()
     */
    protected function _beforeToHtml() {
        $standard = $this->getStandard();
        $form = new Varien_Data_Form();
        $form->setAction( $standard->getRequestUrl() )
            ->setId( 'standard_checkout' )
            ->setName( 'standard_checkout' )
            ->setMethod( 'POST' )
            ->setUseContainer( true );
        foreach ( $standard->getRedirectFields() as $field => $value ) {
            $form->addField( $field, 'hidden', array(
                    'name' => $field,
                    'value' => $value
            ));
        }
        $this->setData('message', Mage::helper('bb')->__('You will be redirected to your bank account in a few momments.'));
        $this->setData('form', $form->toHtml());
        return $this;
    }

    /**
     * @return Quack_BB_Model_Standard
     */
    private function getStandard() {
        $standard = Mage::getModel( 'bb/standard' );
        if ( is_numeric( $this->getRequest()->getParam('order_id') ) ) {
            $order = Mage::getModel('sales/order')->load( $this->getRequest()->getParam('order_id') );
            $standard->setOrder( $order );
        }
        return $standard;
    }

}
