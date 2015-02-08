<?php

// base
require_once 'base/AmoMethod.php';
require_once 'base/AmoGetMethod.php';
require_once 'base/AmoPostMethod.php';
require_once 'interfaces/IMethod.php';
require_once 'methods/AmoAuth.php';

// get methods
require_once 'methods/AmoLeadsList.php';
require_once 'methods/AmoAccountsCurrent.php';
require_once 'methods/AmoContactsList.php';
require_once 'methods/AmoCompanyList.php';
require_once 'methods/AmoTasksList.php';
require_once 'methods/AmoNotesList.php';

// post methods
require_once 'methods/AmoLeadsSet.php';

// links
require_once 'methods/AmoContactsLinks.php';

/**
 * Your comment
 *
 * @author staygreengored <sggr90@gmail.com>
 * @since 1.0
 */
class AmoCrm
{

    /**
     * @var
     */
    public $domain;

    /**
     * @var bool
     */
    public $isAuth = false;

    /**
     * @param $login
     * @param $hash
     * @param $domain
     * @throws Exception
     */
    public function __construct($login, $hash, $domain)
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

    /**
     * @param $name
     * @param $params
     * @return mixed
     */
    public function __call($name, $params) {
        $className = 'Amo'.$name;
        $params['domain'] = $this->domain;
        $object = new $className($params);
        return $object->run();
    }
}