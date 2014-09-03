<?php
/**
 * Your comment
 *
 * @author staygreengored <sggr90@gmail.com>
 * @since 1.0
 */

class AmoNotesList extends AmoGetMethod implements IMethod {

    /**
     * @return string
     */
    public function getMethodName() {
        return '/private/api/v2/json/notes/list';
    }

    /**
     * @return mixed
     */
    public function run() {
        $data = $this->get();
        return $data['notes'];
    }

    /**
     * contact or lead
     * Получение данных только для контакта или сделки
     * @var
     * Обязательный параметр
     */
    public $type;

    /**
     * Уникальный идентификатор контакта или сделки
     * @var
     */
    public $element_id;
}