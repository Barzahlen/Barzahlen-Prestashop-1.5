<?php
/**
 * Barzahlen Payment Module (PrestaShop)
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@barzahlen.de so we can send you a copy immediately.
 *
 * @copyright   Copyright (c) 2012 Zerebro Internet GmbH (http://www.barzahlen.de)
 * @author      Alexander Diebler
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL-3.0)
 */

class Barzahlen_Request_Refund extends Barzahlen_Request_Base {

  protected $_type = 'refund'; //!< request type
  protected $_transactionId; //!< origin transaction id
  protected $_amount; //!< refund amount
  protected $_currency; //!< currency of refund (ISO 4217)

  protected $_xmlAttributes = array('origin-transaction-id', 'refund-transaction-id', 'result', 'hash'); //!< refund xml content

  /**
   * Construtor to set variable request settings.
   *
   * @param string $transactionId origin transaction id
   * @param string $amount refund amount
   * @param string $currency currency of refund (ISO 4217)
   */
  public function __construct($transactionId, $amount, $currency = 'EUR') {

    $this->_transactionId = $transactionId;
    $this->_amount = $amount;
    $this->_currency = $currency;
  }

  /**
   * Builds array for request.
   *
   * @param string $shopId merchants shop id
   * @param string $paymentKey merchants payment key
   * @param string $language langauge code (ISO 639-1)
   * @param array $customVar custom variables from merchant
   * @return array for refund request
   */
  public function buildRequestArray($shopId, $paymentKey, $language) {

    $requestArray = array();
    $requestArray['shop_id'] = $shopId;
    $requestArray['transaction_id'] = $this->_transactionId;
    $requestArray['amount'] = $this->_amount;
    $requestArray['currency'] = $this->_currency;
    $requestArray['language'] = $language;
    $requestArray['hash'] = $this->_createHash($requestArray, $paymentKey);

    $this->_removeEmptyValues($requestArray);
    return $requestArray;
  }

  /**
   * Returns origin transaction id from xml array.
   *
   * @return received origin transaction id
   */
  public function getOriginTransactionId() {
    return $this->getXmlArray('origin-transaction-id');
  }

  /**
   * Returns refund transaction id from xml array.
   *
   * @return received refund transaction id
   */
  public function getRefundTransactionId() {
    return $this->getXmlArray('refund-transaction-id');
  }
}
?>