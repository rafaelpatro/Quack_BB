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
 * @link       https://github.com/rafaelpatro/Quack-BB
 */

class Quack_BB_StandardController extends Mage_Core_Controller_Front_Action
{
	public $data=array();

	/**
	 * Order instance
	 */
	protected $_order;

	/**
	 *  Get order
	 *
	 *  @return   Mage_Sales_Model_Order
	 */
	public function getOrder() {
		if ($this->_order == null) {
		}
		return $this->_order;
	}

	protected function _expireAjax()
	{
		if (!Mage::getSingleton('checkout/session')->getQuote()->hasItems()) {
			$this->getResponse()->setHeader('HTTP/1.1','403 Session Expired');
			exit;
		}
	}

	/**
	 * @return Quack_BB_Model_Standard
	 */
	public function getStandard() {
		return Mage::getSingleton('bb/standard');
	}
	
	public function getHelper() {
		return $this->getStandard()->getHelper();
	}
	
	public function getConfig($field) {
		return $this->getStandard()->getConfigData($field);
	}

	public function redirectAction() {
		$session = Mage::getSingleton('checkout/session');
		$session->setBBStandardQuoteId($session->getQuoteId());
		if ( $this->getStandard()->getOrder()->getPayment() ) {
			$this->getStandard()->getOrder()->sendNewOrderEmail();
		}
		$this->getResponse()->setBody($this->getLayout()->createBlock('bb/redirect')->toHtml());
		$session->unsQuoteId();
		$session->unsRedirectUrl();
	}

	public function cancelAction() {
		$session = Mage::getSingleton('checkout/session');
		$session->setQuoteId($session->getBBQuoteId(true));
		if ($session->getLastRealOrderId()) {
			$order = Mage::getModel('sales/order')->loadByIncrementId($session->getLastRealOrderId());
			if ($order->getId()) {
				$order->cancel()->save();
			}
		}
		$this->_redirect('checkout/cart');
	}

	public function successAction() {
		$session = Mage::getSingleton('checkout/session');
		$session->setQuoteId($session->getBBStandardQuoteId(true));
		Mage::getSingleton('checkout/session')->getQuote()->setIsActive(false)->save();
		$this->_redirect('checkout/onepage/success', array('_secure'=>false));
	}
	
	public function returnAction() {
		$session = Mage::getSingleton('core/session'); /* @var $session Mage_Core_Model_Session */
		$refTran = $this->getRequest()->getParam('refTran');
		$idCobr  = substr($refTran, 0, 7);
		$orderId = substr($refTran, 7);
		if ($idCobr == $this->getConfig('refTran')) {
			try {/* @var $order Mage_Sales_Model_Order */
				$order = Mage::getModel("sales/order")->load((int)$orderId);
				if ($order->canInvoice()) {
					$invoice = $order->prepareInvoice();
					$invoice->setRequestedCaptureCase(Mage_Sales_Model_Order_Invoice::CAPTURE_ONLINE);
					$invoice->register();
					$invoice->getOrder()->setIsInProcess(true);
					// $order->addStatusHistoryComment($this->getHelper()->getTypeMessage($tipPag));
					$transaction = Mage::getModel('core/resource_transaction')
						->addObject($invoice)
						->addObject($invoice->getOrder());
					$transaction->save();
					// $invoice->sendEmail(true);
					$session->addSuccess("Pedido efetuado com sucesso!");
				}
			} catch (Exception $e) {
				$session->addError($e->getMessage());
				$session->addNotice("Se já efetuou o pagamento, aguarde alguns instantes, a confirmação aparecerá em breve.");
				$session->addNotice("Caso não tenha conseguido realizar o pagamento, acesse seu pedido, e clique em Efetuar Pagamento.");
			}
		}
		$this->_redirect("sales/order/history");
	}
}
?>
