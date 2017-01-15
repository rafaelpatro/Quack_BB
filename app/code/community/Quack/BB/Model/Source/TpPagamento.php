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

class Quack_BB_Model_Source_TpPagamento {
    public function toOptionArray() {
        return array(
            array('value' => '0', 'label' => '0 - Todas as modalidades contratadas pelo convenente'),
            array('value' => '2', 'label' => '2 - Boleto Bancário'),
            array('value' => '21','label' => '21 - 2ª via de Boleto Bancário, já gerado anteriormente'),
            array('value' => '3', 'label' => '3 - Débito em Conta via Internet - PF e PJ'),
            array('value' => '5', 'label' => '5 - BB Crediário Internet'),
            array('value' => '7', 'label' => '7 - Débito em Conta via Internet PF'),
        );
    }
}
