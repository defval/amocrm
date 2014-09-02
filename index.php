<?php
/**
 * Your comment
 *
 * @author staygreengored <sggr90q@gmail.com>
 * @since 1.0
 */

require_once 'yii-amocrm/AmoCrm.php';
try {
    $result = new AmoCrm('login', 'hash', 'domain');
    $r = $result->leadsList(array('query' => 123));
}
catch(Exception $e) {
    echo $e->getMessage();
}
//print_r($result);