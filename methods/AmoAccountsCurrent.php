<?php
/**
 * Your comment
 *
 * @author staygreengored <sggr90@gmail.com>
 * @since 1.0
 */

class AmoAccountsCurrent extends AmoGetMethod implements IMethod {

    /**
     * @return mixed|string
     */
    public function getMethodName() {
        return '/private/api/v2/json/accounts/current';
    }

    /**
     * @return mixed
     */
    public function run() {
        $data = $this->get();
        return $data['account'];
    }

} 