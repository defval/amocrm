<?php
/**
 * Your comment
 *
 * @author staygreengored <sggr90@gmail.com>
 * @since 1.0
 */

class AmoAuth extends AmoPostMethod implements IMethod {

    protected $USER_LOGIN;

    protected $USER_HASH;

    public function getMethodName() {
        return '/private/api/auth.php';
    }

    public function run() {
        return $this->post(array(
            'USER_LOGIN'    => $this->USER_LOGIN,
            'USER_HASH'     => $this->USER_HASH
        ));
    }
}