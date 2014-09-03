<?php

require_once 'base/AmoMethod.php';
require_once 'base/AmoGetMethod.php';
require_once 'base/AmoPostMethod.php';
require_once 'interfaces/IMethod.php';
require_once 'methods/AmoAuth.php';
require_once 'methods/AmoLeadsList.php';

/**
 * Your comment
 *
 * @author staygreengored <sggr90@gmail.com>
 * @since 1.0
 */
class AmoCrm
{

    public $domain;

    public $isAuth = false;

    public function __construct($login = '', $hash = '', $domain = '')
    {
        $this->domain = $domain;

        $auth = $this->auth(array(
            'USER_LOGIN' => $login,
            'USER_HASH'  => $hash
        ));

        if(!isset($auth['auth'])) {
            throw new Exception('u dont auth');
        };

        $this->isAuth = true;

    }

    public function __call($name, $params) {
        $className = 'Amo'.$name;
        $params['domain'] = $this->domain;
        $object = new $className($params);
        return $object->run();
    }
}