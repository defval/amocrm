<?php
/**
 * Your comment
 *
 * @author staygreengored <sggr90@gmail.com>
 * @since 1.0
 */

class AmoContactsList extends AmoGetMethod implements IMethod {

    /**
     * @return string
     */
    public function getMethodName() {
        return '/private/api/v2/json/contacts/list';
    }

    /**
     * @return mixed
     */
    public function run() {
        $data = $this->get();
        return $data['contacts'];
    }

    /**
     * Искомый элемент, по текстовому запросу
     * (Осуществляет поиск по таким полям как : почта, телефон и любым иным полям, Не осуществляет поиск по заметкам и задачам
     * @var
     */
    public $query;

    /**
     * Дополнительный фильтр поиска, по ответственному пользователю
     * @var
     */
    public $responsible_user_id;

    /**
     * Тип контакта: contact(по-умолчанию), company или all
     * @var
     */
    public $type;
}