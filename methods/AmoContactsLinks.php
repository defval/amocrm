<?php
/**
 * Your comment
 *
 * @author staygreengored <sggr90@gmail.com>
 * @since 1.0
 */


class AmoContactsLinks extends AmoGetMethod implements IMethod {
    public function getMethodName() {
        return '/private/api/v2/json/contacts/links';
    }

    public function run() {
        $data = $this->get();
        return $data['links'];
    }
}