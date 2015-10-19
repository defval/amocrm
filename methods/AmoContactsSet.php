<?php
/**
 * Set contacts in amocrm
 *
 * example:
 * $amo = new AmoCrm('LOGIN', 'HASH', 'DOMAIN');
 *   $contacts = [
 *     array(
 *      'name' => 'Test contact'
 *     )
 *   ];
 *   $result = $amo->ContactsSet(array('add' => $contacts));
 *
 * @author fr2@mail.ru(https://github.com/seeker1983)
 * @since 1.0
 */

class AmoContactsSet extends AmoPostMethod implements IMethod {

  /**
   * Получение имени метода для запроса к API
   * @return mixed
   */
  public function getMethodName() {
      return '/private/api/v2/json/contacts/set';
  }

  /**
   * Код метода
   * @return mixed
   * response:
   *  Array (
   *   [contacts] => Array (
   *     [add] => Array (
   *       [0] => Array (
   *         [id] => 30385385
   *         [request_id] => 0
   *       )
   *     )
   *   )
   *   [server_time] => 1423379385
   * )
   */
  public function run() {
    $request = array(
      'request' => array(
        'contacts' => array(
          'add' => $this->add,
          'update' => $this->update
        )
      )
    );
    return $this->post($request);
  }

  /**
   * Array of creating contacts
   * @var
   */
  public $add;

  /**
   * Array of updating contacts
   * @var
   */
  public $update;
}
