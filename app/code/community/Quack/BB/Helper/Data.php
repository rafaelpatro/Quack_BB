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
            case '00': $message = $this->__("pagamento efetuado"); break;
            case '01': $message = $this->__("pagamento não autorizado/transação recusada"); break;
            case '03': $message = $this->__("pagamento não localizado"); break;
            case '10': $message = $this->__("campo idConv inválido ou nulo"); break;
            case '11': $message = $this->__("valor informado é inválido, nulo ou não confere com o valor registrado"); break;
            case '21': $message = $this->__("pagamento web não autorizado"); break;
            case '24': $message = $this->__("convênio não cadastrado"); break;
            case '25': $message = $this->__("convênio não ativo"); break;
            case '26': $message = $this->__("convênio não permite débito em conta"); break;
            case '27': $message = $this->__("serviço inválido"); break;
            case '28': $message = $this->__("boleto emitido"); break;
            case '29': $message = $this->__("pagamento não efetuado"); break;
            case '99': $message = $this->__("operação cancelada pelo cliente"); break;
            case '02':
            case '22': 
            case '23':
            case '30': $message = $this->__("erro no processamento da consulta"); break;
        }
        return $message;
    }
    
    public function getTypeMessage($type) {
        $message = $this->__("undefined bank method %s", $type);
        switch ($type) {
            case '0': $message = $this->__("payment not selected yet"); break;
            case '21':
            case '2': $message = $this->__("Bank Slip"); break;
            case '3':
            case '7': $message = $this->__("Online Debit"); break;
            case '5': $message = $this->__("Installment Plan"); break;
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
        $city = preg_replace('/[^A-Z\'\-\s]/g', '', $city);
        $city = preg_replace('/[\s\'\-]{2,}/g', ' ', $city);
        $city = trim($city);
        $city = substr($city, 0, 18);
        return $city;
    }
    
    public function getFormattedPostcode($addr) {
        $postcode = $addr->getPostcode();
        $postcode = preg_replace('/[^\d]/g', '', $postcode);
        $postcode = substr($postcode, 0, 8);
        return $postcode;
    }
    
    public function getFormattedAddress($addr) {
        $streetFull = strtoupper($addr->getStreetFull());
        $streetFull = preg_replace('/[^A-Z\'\-\s]/g', '', $streetFull);
        $streetFull = preg_replace('/[\s\'\-]{2,}/g', ' ', $streetFull);
        $streetFull = substr($streetFull, 0, 60);
        return $streetFull;
    }
}
?>
