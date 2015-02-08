<?php
/**
 * Set leads in amocrm
 *
 * example:
 * $amo = new AmoCrm('LOGIN', 'HASH', 'DOMAIN');
 *   $leads = [
 *     array(
 *      'name' => 'test test test',
 *      'status_id' => 8227884,
 *      'price' => 0,
 *      'responsible_user_id' => 346072,
 *      'tags' => 'LP'
 *     )
 *   ];
 *   $result = $amo->LeadsSet(array('add' => $leads));
 *
 * @author v.v.mamaev <v.v.mamaev@yandex.ru>
 * @since 1.0
 */

class AmoLeadsSet extends AmoPostMethod implements IMethod {

  /**
   * Получение имени метода для запроса к API
   * @return mixed
   */
  public function getMethodName() {
      return '/private/api/v2/json/leads/set';
  }

  /**
   * Код метода
   * @return mixed
   * response:
   *  Array (
   *   [leads] => Array (
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
        'leads' => array(
          'add' => $this->add,
          'update' => $this->update
        )
      )
    );
    return $this->post($request);
  }

  /**
   * Array of creating leads
   * @var
   */
  public $add;

  /**
   * Array of updating leads
   * @var
   */
  public $update;
}
