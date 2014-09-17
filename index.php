<?php
/**
 * Your comment
 *
 * @author staygreengored <sggr90q@gmail.com>
 * @since 1.0
 */

require_once 'AmoCrm.php';
try {
    $result = new AmoCrm('pivnev.wlad@gmail.com', '837d208087635577386521ba04681ae7', 'visaglobus');
    $r = $result->ContactsList(array('id' => array(23020462, 23020350)));
    echo '<pre>';
    print_r($r);
    echo '</pre>';
}
catch(Exception $e) {
    echo $e->getMessage();
}
//print_r($result);