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

class Quack_BB_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getStatusMessage($status) {
        $message = $this->__("undefined bank status %s", $status);
        switch ($status) {
            case Quack_BB_Model_Source_Situacao::RECEIVED:
                $message = $this->__("pagamento efetuado");
                break;
            case Quack_BB_Model_Source_Situacao::REJECTED:
                $message = $this->__("pagamento não autorizado/transação recusada");
                break;
            case Quack_BB_Model_Source_Situacao::NOT_FOUND:
                $message = $this->__("pagamento não localizado");
                break;
            case Quack_BB_Model_Source_Situacao::INVALID_ID:
                $message = $this->__("campo idConv inválido ou nulo");
                break;
            case Quack_BB_Model_Source_Situacao::INVALID_VALUE:
                $message = $this->__("valor informado é inválido, nulo ou não confere com o valor registrado");
                break;
            case Quack_BB_Model_Source_Situacao::UNAUTHORIZED:
                $message = $this->__("pagamento web não autorizado");
                break;
            case Quack_BB_Model_Source_Situacao::NOT_FOUND_ID:
                $message = $this->__("convênio não cadastrado");
                break;
            case Quack_BB_Model_Source_Situacao::INACTIVE_ID:
                $message = $this->__("convênio não ativo");
                break;
            case Quack_BB_Model_Source_Situacao::DISALLOWED_DEBIT:
                $message = $this->__("convênio não permite débito em conta");
                break;
            case Quack_BB_Model_Source_Situacao::INVALID_METHOD:
                $message = $this->__("serviço inválido");
                break;
            case Quack_BB_Model_Source_Situacao::DOC_ISSUED:
                $message = $this->__("boleto emitido");
                break;
            case Quack_BB_Model_Source_Situacao::NOT_RECEIVED:
                $message = $this->__("pagamento não efetuado");
                break;
            case Quack_BB_Model_Source_Situacao::CANCELLED:
                $message = $this->__("operação cancelada pelo cliente");
                break;
            case Quack_BB_Model_Source_Situacao::PROCESSING_ERROR_02:
            case Quack_BB_Model_Source_Situacao::PROCESSING_ERROR_22: 
            case Quack_BB_Model_Source_Situacao::PROCESSING_ERROR_23:
            case Quack_BB_Model_Source_Situacao::PROCESSING_ERROR_30:
                $message = $this->__("erro no processamento da consulta");
                break;
        }
        return $message;
    }
    
    public function getTypeMessage($type) {
        $message = $this->__("undefined bank method %s", $type);
        switch ($type) {
            case Quack_BB_Model_Source_TpPagamento::NOT_SET :
                $message = $this->__("payment not selected yet");
                break;
            case Quack_BB_Model_Source_TpPagamento::BANK_SLIP_DUPLICATE :
            case Quack_BB_Model_Source_TpPagamento::BANK_SLIP :
                $message = $this->__("Bank Slip");
                break;
            case Quack_BB_Model_Source_TpPagamento::ONLINE_DEBIT :
            case Quack_BB_Model_Source_TpPagamento::ONLINE_DEBIT_FISICAL :
                $message = $this->__("Online Debit");
                break;
            case Quack_BB_Model_Source_TpPagamento::INSTALLMENT_PLAN :
                $message = $this->__("Installment Plan");
                break;
        }
        return $message;
    }
    
    public function strtoascii($str) {
        setlocale(LC_ALL, 'pt_BR.utf8');
        return iconv('UTF-8', 'ASCII//TRANSLIT', $str);
    }
    
    public function getExpirationDate($date, $deadline) {
        $time = new DateTime($date);
        $time->add(new DateInterval("P{$deadline}D"));
        return $time->format('dmY');
    }
    
    public function getFormattedCity($addr) {
        $city = strtoupper($addr->getCity());
        $city = $this->strtoascii($city);
        $city = preg_replace('/[^A-Z\'\-\s]/', '', $city);
        $city = preg_replace('/[\s\'\-]{2,}/', ' ', $city);
        $city = preg_replace('/[\n\r\t]/', ' ', $city);
        $city = trim($city);
        $city = substr($city, 0, 18);
        return $city;
    }
    
    public function getFormattedPostcode($addr) {
        $postcode = $addr->getPostcode();
        $postcode = preg_replace('/[^\d]/', '', $postcode);
        $postcode = substr($postcode, 0, 8);
        return $postcode;
    }
    
    public function getFormattedAddress($addr) {
        $streetFull = strtoupper($addr->getStreetFull());
        $streetFull = $this->strtoascii($streetFull);
        $streetFull = preg_replace('/[^0-9A-Z\'\-\s]/', '', $streetFull);
        $streetFull = preg_replace('/[\s\'\-]{2,}/', ' ', $streetFull);
        $streetFull = preg_replace('/[\n\r\t]/', ' ', $streetFull);
        $streetFull = substr($streetFull, 0, 60);
        return $streetFull;
    }
    
    /**
     * Retrieve formatted Name by order address
     * 
     * @param Mage_Sales_Model_Order_Address $addr
     * @return string
     */
    public function getFormattedCustomerName($addr) {
        $name = "{$addr->getFirstname()} {$addr->getLastname()}";
        $name = $this->getFormattedName($name);
        return $name;
    }

    /**
     * Retrieve formatted Company by order address
     *
     * @param Mage_Sales_Model_Order_Address $addr
     * @return string
     */
    public function getFormattedCompanyName($addr) {
        $name = $addr->getFirstname();
        $name = $this->getFormattedName($name);
        return $name;
    }
    
    public function getFormattedName($name) {
        $name = strtoupper($name);
        $name = $this->strtoascii($name);
        $name = preg_replace('/[^A-Z\'\-\s]/', '', $name);
        $name = preg_replace('/[\s\'\-]{2,}/', ' ', $name);
        $name = substr($name, 0, 60);
        return $name;
    }
    
    public function getFormattedAmount($amount) {
        $amount = number_format($amount, 2, '', '');
        return $amount;
    }
    
    public function isBankSlipAvailable($type) {
        return in_array($type, array(
            Quack_BB_Model_Source_TpPagamento::NOT_SET,
            Quack_BB_Model_Source_TpPagamento::BANK_SLIP,
            Quack_BB_Model_Source_TpPagamento::BANK_SLIP_DUPLICATE
        ));
    }
}
?>
