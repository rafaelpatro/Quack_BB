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

class Quack_BB_Model_Standard extends Mage_Payment_Model_Method_Abstract {

    const PAYMENT_TYPE_AUTH = 'AUTHORIZATION';
    const PAYMENT_TYPE_SALE = 'SALE';

    protected $_code  = 'bb_standard';
    protected $_formBlockType = 'bb/form';
    protected $_allowCurrencyCode = array('BRL');

    protected $_canUseInternal = true;
    protected $_canCapture = true;
    protected $_canUseForMultishipping = true;

    protected $_order = null;

    public function getSession() {
        return Mage::getSingleton('bb/session');
    }

    /**
     * Get checkout session namespace
     * @return Mage_Checkout_Model_Session
     */
    public function getCheckout() {
        return Mage::getSingleton('checkout/session');
    }

    /**
     * Get current quote
     *
     * @return Mage_Sales_Model_Quote
     */
    public function getQuote() {
        return $this->getCheckout()->getQuote();
    }

    public function createFormBlock($name) {
        $block = $this->getLayout()->createBlock('bb/form', $name)
            ->setMethod ( 'bb_standard' )
            ->setPayment( $this->getPayment() );
        return $block;
    }

    public function getTransactionId() {
        return $this->getSessionData('transaction_id');
    }

    public function setTransactionId($data) {
        return $this->setSessionData('transaction_id', $data);
    }

    public function validate() {
        parent::validate();
        $currency_code = $this->getQuote()->getBaseCurrencyCode();
        if ($currency_code == '') {
            $currency_code = Mage::getSingleton('adminhtml/session_quote')->getQuote()->getBaseCurrencyCode();
        }
        if (!in_array($currency_code,$this->_allowCurrencyCode)) {
            Mage::throwException(Mage::helper('bb')->__('A moeda selecionada ('.$currency_code.') não é compatível com o método de pagamento'));
        }
        return $this;
    }

    public function onOrderValidate(Mage_Sales_Model_Order_Payment $payment) {
       return $this;
    }

    public function onInvoiceCreate(Mage_Sales_Model_Order_Payment $payment) {
        return $this;
    }

    public function getOrderPlaceRedirectUrl() {
        if ($this->getConfigData('allowredirect') == 1) {
            return Mage::getUrl('bb/standard/redirect');
        }
        return;
    }
    
    /**
     * @param Mage_Sales_Model_Order $order
     * @return Quack_BB_Model_Standard
     */
    public function setOrder($order) {
        $this->_order = $order;
        return $this;
    }
    
    /**
     * @return Mage_Sales_Model_Order
     */
    public function getOrder() {
        if (!($this->_order instanceof Mage_Sales_Model_Order)) {
            $this->_order = Mage::getModel( 'sales/order' );
            $orderIncrementId = $this->getCheckout()->getLastRealOrderId();
            $this->_order->loadByIncrementId( $orderIncrementId );
        }
        return $this->_order;
    }
    
    public function getTpPagamento() {
        $tpPagamento = $this->getConfigData('tppagamento');
        try {
            $method = $this->getInfoInstance()->getAdditionalInformation('paymentType');
            $status = $this->getInfoInstance()->getAdditionalInformation('paymentStatus');
            if ($method == Quack_BB_Model_Source_TpPagamento::BANK_SLIP
                && $status == Quack_BB_Model_Source_Situacao::DOC_ISSUED) {
                $tpPagamento = Quack_BB_Model_Source_TpPagamento::BANK_SLIP_DUPLICATE;
            }
        } catch (Exception $e) {    
        }
        return $tpPagamento;
    }
        
    /**
     * @param Mage_Sales_Model_Order $order
     * @return array
     */
    public function getRedirectFields() {
        $this->log("Quack_BB_Model_Standard::getRedirectFields() started");
        $order = $this->getOrder();
        $addr  = $order->getBillingAddress();
        
        $idConv  = substr($this->getConfigData('idconv'), 0, 6);
        $refTran = $this->getConfigData('reftran').sprintf("%010d", $order->getEntityId());
        $refTran = substr($refTran, 0, 17);
        
        /* @var $request Quack_BB_Model_Request */
        $request = Mage::getModel('bb/request');
        $request
            ->setIdConv($idConv)
            ->setRefTran($refTran)
            ->setValor($this->getHelper()->getFormattedAmount($order->getGrandTotal()))
            ->setDtVenc(date('dmY'))
            ->setTpPagamento($this->getTpPagamento())
            ->setUrlRetorno($this->getConfigData('urlretorno'));

        if ($this->getHelper()->isBankSlipAvailable( $request->getTpPagamento() )) {
            $dtVenc = $this->getHelper()->getExpirationDate(date('Y-m-d'), $this->getConfigData('dtvenc'));
            $digits = new Zend_Filter_Digits();
            $cpfCnpj = $digits->filter($order->getData('customer_taxvat'));
            $indPessoa = (strlen($cpfCnpj) == 11) ? '1' : '2';
            $name = $this->getHelper()->getFormattedCustomerName($addr);
            if ($indPessoa=1)
                $name = $this->getHelper()->getFormattedCompanyName($addr);
            $request
                ->setDtVenc($dtVenc)
                ->setCpfCnpj($cpfCnpj)
                ->setIndicadorPessoa($indPessoa)
                ->setTpDuplicata($this->getConfigData('tpduplicata'))
                ->setNome($name)
                ->setEndereco($this->getHelper()->getFormattedAddress($addr))
                ->setCidade($this->getHelper()->getFormattedCity($addr))
                ->setUf($addr->getRegionCode())
                ->setCep($this->getHelper()->getFormattedPostcode($addr))
                ->setMsgLoja($this->getConfigData('msgloja'));

            $isDiscountActive = ($order->getDiscountAmount() > 0);
            $isDiscountActive&= ($this->getConfigData('valordesconto') == 1);
            if ($isDiscountActive) {
                $newTotal = $order->getGrandTotal() + $order->getDiscountAmount();
                $newTotal = $this->getHelper()->getFormattedAmount($newTotal);
                $request->setValor($newTotal);
                $discount = $this->getHelper()->getFormattedAmount($order->getDiscountAmount());
                $request->setValorDesconto($discount);
                $dataLimiteDesconto = $this->getHelper()
                    ->getExpirationDate(date('Y-m-d'), $this->getConfigData('datalimitedesconto'));
                $request->setDataLimiteDesconto($dataLimiteDesconto);
            }
        }
        
        /*if ($this->getConfigData('pontopravoce') == 1) {
            $isPF = (strlen($request->getCpfCnpj()) == 11);
            $request->setTpPagamento($isPF ? '61' : '62');
            $refTran = $this->getConfigData('idPontopravoce').sprintf("%08d", $order->getEntityId());
            $request->setRefTran($refTran);
        }*/
        
        return (array)$request;
    }

    public function getRequestUrl() {
        return $this->getConfigData('urlbb');
    }

    public function getSondaUrl() {
        return $this->getConfigData('urlsonda');
    }
    
    /**
     * @return Quack_BB_Helper_Data
     */
    public function getHelper() {
        return Mage::helper('bb/data');
    }
    
    /**
     * (non-PHPdoc)
     * @see Mage_Payment_Model_Method_Abstract::capture()
     */
    public function capture(Varien_Object $payment, $amount) {
        parent::capture($payment, $amount);
        $this->log("Quack_BB_Model_Standard::capture() started");
        try {/* @var $request Quack_BB_Model_Sonda */
            $parentId = sprintf("%010d", $payment->getParentId());
            $request  = Mage::getModel('bb/sonda')
                ->setIdConv($this->getConfigData('idconv'))
                ->setValorSonda( number_format($amount, 2, '', '') )
                ->setRefTran("{$this->getConfigData('reftran')}{$parentId}")
                ->setFormato('02');
            $sonda = $this->sonda( (array)$request );
            $this->getInfoInstance()
                ->setAdditionalInformation( 'paymentType'   , (string)$sonda->getTpPagamento())
                ->setAdditionalInformation( 'paymentStatus' , (string)$sonda->getSituacao())
                ->save();
        } catch (Exception $e) {
            Mage::throwException($e->getMessage());
        }
        if ($sonda->getSituacao() != Quack_BB_Model_Source_Situacao::RECEIVED) {
            $typeMsg = Mage::helper('bb')->__("Method {$sonda->getTpPagamento()}");
            $statMsg = Mage::helper('bb')->__("Status {$sonda->getSituacao()}");
            Mage::throwException("{$typeMsg}: {$statMsg}");
        }
        return $this;
    }
    
    /**
     * @param array $params
     * @return Quack_BB_Model_Sonda
     */
    public function sonda($params) {
        $this->log("Quack_BB_Model_Standard::sonda() started");
        $client = new Zend_Http_Client($this->getSondaUrl());
        $client->setParameterPost( $params );
        $result = $client->request('POST')->getBody();
        $this->log("URI: {$client->getLastRequest()}");
        $result = preg_replace('/<\![^>]*>/', '', $result); // remove doctype and cdata declarations
        $result = preg_replace('/<\?[^>]*>/', '', $result); // remove xml version and charset declaration
        $sonda = Mage::getModel('bb/sonda'); /* @var $sonda Quack_BB_Model_Sonda */
        $xml = @simplexml_load_string($result);
        foreach ($xml->children() as $child) {
            $sonda->setDataUsingMethod( $child['nome'], (string) $child['valor'] );
        }
        $this->log($result);
        return $sonda;
    }
    
    /**
     * @param string $message
     * @return Quack_BB_Model_Standard
     */
    public function log($message) {
        Mage::log($message, null, 'bb.log');
        return $this;
    }
}
