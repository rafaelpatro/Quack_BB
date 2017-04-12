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

class Quack_BB_Model_Request extends Varien_Object
{

    /**
     * Código do convênio de Comércio Eletrônico fornecido pelo Banco
     *
     * @var string
     */
    public $idConv;

    /**
     * Número atribuído, gerado e controlado pelo Convenente, que identifica o
     * pedido de compra em todas as fases do processo de pagamento
     *
     * @var string
     */
    public $refTran;

    /**
     * Valor total da compra em Reais, com centavos, sem formatação
     *
     * @var string
     */
    public $valor;

    /**
     * Quantidade de pontos que serão resgatados no programa de Relacionamento
     *
     * @var string
     */
    public $qtdPontos;

    /**
     * Data de vencimento do pagamento, no formato DDMMAAAA
     *
     * @var string
     */
    public $dtVenc;

    /**
     * Modalidade de pagamento:
     * 0 – Todas as modalidades contratadas pelo convenente
     * 2 – Boleto bancário
     * 21 – 2ª Via de boleto bancário, já gerado anteriormente
     * 3 – Débito em Conta via Internet – PF e PJ
     * 5 – BB Crediário Internet
     * 7 - Débito em Conta via Internet PF
     *
     * @var string
     */
    public $tpPagamento;

    /**
     * É o número do CPF ou CNPJ do comprador
     *
     * @var string
     */
    public $cpfCnpj;

    /**
     * Indica que o nº enviado na variável cpf/Cnpj é de uma pessoa física = 1
     * ou uma pessoa jurídica = 2
     *
     * @var string
     */
    public $indicadorPessoa;

    /**
     * Valor do desconto em Reais, com centavos, sem formatação
     *
     * @var string
     */
    public $valorDesconto;

    /**
     * Data de vencimento do pagamento, no formato DDMMAAAA
     *
     * @var string
     */
    public $dataLimiteDesconto;

    /**
     * Informa o tipo de título que originará o boleto
     *
     * @var string
     */
    public $tpDuplicata;

    /**
     * Endereço (URL) para o qual o cliente será direcionado, através do
     * formulário Retorno, caso deseje voltar identificado ao site do
     * convenente, a partir da última página do processo de pagamento,
     * clicando em botão disponível nessa página.
     *
     * @var string
     */
    public $urlRetorno;

    /**
     * Complemento de endereço (URL) que será acionado,
     * indicando que uma transação foi finalizada no site do
     * BB, cabendo ao convenente acionar o Formulário
     * Sonda para confirmar a liquidação financeira da
     * compra
     *
     * @var string
     */
    public $urlInforma;

    /**
     * Nome do comprador, que será apresentado no boleto de cobrança
     * 
     * @var string
     */
    public $nome;

    /**
     * Endereço do comprador, que será apresentado no boleto de cobrança
     * 
     * @var string
     */
    public $endereco;

    /**
     * Cidade do comprador, que será apresentada no boleto de cobrança
     * 
     * @var string
     */
    public $cidade;

    /**
     * Estado do comprador, que será apresentado no boleto de cobrança
     * 
     * @var string
     */
    public $uf;

    /**
     * CEP do comprador, sem hífen, que será apresentado no boleto de cobrança
     * 
     * @var string
     */
    public $cep;

    /**
     * Instruções do beneficiário
     * 
     * @var string
     */
    public $msgLoja;

    /**
     *
     * @return string
     */
    public function getIdConv()
    {
        return $this->idConv;
    }

    /**
     *
     * @param string $idConv            
     */
    public function setIdConv($idConv)
    {
        $this->idConv = $idConv;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getRefTran()
    {
        return $this->refTran;
    }

    /**
     *
     * @param string $refTran            
     */
    public function setRefTran($refTran)
    {
        $this->refTran = $refTran;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     *
     * @param string $valor            
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getQtdPontos()
    {
        return $this->qtdPontos;
    }

    /**
     *
     * @param string $qtdPontos            
     */
    public function setQtdPontos($qtdPontos)
    {
        $this->qtdPontos = $qtdPontos;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getDtVenc()
    {
        return $this->dtVenc;
    }

    /**
     *
     * @param string $dtVenc            
     */
    public function setDtVenc($dtVenc)
    {
        $this->dtVenc = $dtVenc;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getTpPagamento()
    {
        return $this->tpPagamento;
    }

    /**
     *
     * @param string $tpPagamento            
     */
    public function setTpPagamento($tpPagamento)
    {
        $this->tpPagamento = $tpPagamento;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getCpfCnpj()
    {
        return $this->cpfCnpj;
    }

    /**
     *
     * @param string $cpfCnpj            
     */
    public function setCpfCnpj($cpfCnpj)
    {
        $this->cpfCnpj = $cpfCnpj;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getIndicadorPessoa()
    {
        return $this->indicadorPessoa;
    }

    /**
     *
     * @param string $indicadorPessoa            
     */
    public function setIndicadorPessoa($indicadorPessoa)
    {
        $this->indicadorPessoa = $indicadorPessoa;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getValorDesconto()
    {
        return $this->valorDesconto;
    }

    /**
     *
     * @param string $valorDesconto            
     */
    public function setValorDesconto($valorDesconto)
    {
        $this->valorDesconto = $valorDesconto;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getDataLimiteDesconto()
    {
        return $this->dataLimiteDesconto;
    }

    /**
     *
     * @param string $dataLimiteDesconto            
     */
    public function setDataLimiteDesconto($dataLimiteDesconto)
    {
        $this->dataLimiteDesconto = $dataLimiteDesconto;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getTpDuplicata()
    {
        return $this->tpDuplicata;
    }

    /**
     *
     * @param string $tpDuplicata            
     */
    public function setTpDuplicata($tpDuplicata)
    {
        $this->tpDuplicata = $tpDuplicata;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getUrlRetorno()
    {
        return $this->urlRetorno;
    }

    /**
     *
     * @param string $urlRetorno            
     */
    public function setUrlRetorno($urlRetorno)
    {
        $this->urlRetorno = $urlRetorno;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getUrlInforma()
    {
        return $this->urlInforma;
    }

    /**
     *
     * @param string $urlInforma            
     */
    public function setUrlInforma($urlInforma)
    {
        $this->urlInforma = $urlInforma;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     *
     * @param string $nome            
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     *
     * @param string $endereco            
     */
    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     *
     * @param string $cidade            
     */
    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getUf()
    {
        return $this->uf;
    }

    /**
     *
     * @param string $uf            
     */
    public function setUf($uf)
    {
        $this->uf = $uf;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     *
     * @param string $cep            
     */
    public function setCep($cep)
    {
        $this->cep = $cep;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getMsgLoja()
    {
        return $this->msgLoja;
    }

    /**
     *
     * @param string $msgLoja            
     */
    public function setMsgLoja($msgLoja)
    {
        $this->msgLoja = $msgLoja;
        return $this;
    }
}
