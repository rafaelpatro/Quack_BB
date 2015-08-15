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

class Quack_BB_Model_Sonda extends Varien_Object {
	/**
	 * @var string
	 */
	public $idConv;
	/**
	 * @var string
	 */
	public $refTran;
	/**
	 * @var string
	 */
	public $valorSonda;
	/**
	 * @var string
	 */
	public $formato;
	/**
	 * @var string
	 */
	protected $valor;
	/**
	 * @var string
	 */
	protected $tpPagamento;
	/**
	 * @var string
	 */
	protected $situacao;
	/**
	 * @var string
	 */
	protected $dataPagamento;
	
	/**
	 *
	 * @return string
	 */
	public function getIdConv() {
		return $this->idConv;
	}
	
	/**
	 *
	 * @param
	 *        	$idConv
	 */
	public function setIdConv($idConv) {
		$this->idConv = $idConv;
		return $this;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getRefTran() {
		return $this->refTran;
	}
	
	/**
	 *
	 * @param
	 *        	$refTran
	 */
	public function setRefTran($refTran) {
		$this->refTran = $refTran;
		return $this;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getValorSonda() {
		return $this->valorSonda;
	}
	
	/**
	 *
	 * @param
	 *        	$valorSonda
	 */
	public function setValorSonda($valorSonda) {
		$this->valorSonda = $valorSonda;
		return $this;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getValor() {
		return $this->valor;
	}
	
	/**
	 *
	 * @param
	 *        	$valor
	 */
	public function setValor($valor) {
		$this->valor = $valor;
		return $this;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getTpPagamento() {
		return $this->tpPagamento;
	}
	
	/**
	 *
	 * @param
	 *        	$tpPagamento
	 */
	public function setTpPagamento($tpPagamento) {
		$this->tpPagamento = $tpPagamento;
		return $this;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getSituacao() {
		return $this->situacao;
	}
	
	/**
	 *
	 * @param
	 *        	$situacao
	 */
	public function setSituacao($situacao) {
		$this->situacao = $situacao;
		return $this;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getDataPagamento() {
		return $this->dataPagamento;
	}
	
	/**
	 *
	 * @param
	 *        	$dataPagamento
	 */
	public function setDataPagamento($dataPagamento) {
		$this->dataPagamento = $dataPagamento;
		return $this;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getFormato() {
		return $this->formato;
	}
	
	/**
	 *
	 * @param
	 *        	$formato
	 */
	public function setFormato($formato) {
		$this->formato = $formato;
		return $this;
	}
	
	
}