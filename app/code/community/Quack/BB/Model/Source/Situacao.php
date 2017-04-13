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

class Quack_BB_Model_Source_Situacao {
    
    const RECEIVED            = '00';
    const REJECTED            = '01';
    const PROCESSING_ERROR_02 = '02';
    const NOT_FOUND           = '03';
    const INVALID_ID          = '10';
    const INVALID_VALUE       = '11';
    const UNAUTHORIZED        = '21';
    const PROCESSING_ERROR_22 = '22';
    const PROCESSING_ERROR_23 = '23';
    const NOT_FOUND_ID        = '24';
    const INACTIVE_ID         = '25';
    const DISALLOWED_DEBIT    = '26';
    const INVALID_METHOD      = '27';
    const DOC_ISSUED          = '28';
    const NOT_RECEIVED        = '29';
    const PROCESSING_ERROR_30 = '30';
    const CANCELLED           = '99';
}