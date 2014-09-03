<?php
/**
 * Your comment
 *
 * @author staygreengored <sggr90@gmail.com>
 * @since 1.0
 */

class AmoTasksList extends AmoGetMethod implements IMethod {

    /**
     * @return string
     */
    public function getMethodName() {
        return '/private/api/v2/json/tasks/list';
    }

    /**
     * @return mixed
     */
    public function run() {
        $data = $this->get();
        return $data['tasks'];
    }

    /**
     * Дополнительный фильтр поиска, по ответственному пользователю
     * @var
     */
    public $responsible_user_id;

    /**
     * contact or lead
     * Получение данных только для контакта или сделки
     * при отсутствии этого параметра будут полученны все данные, в том числе не прикрепленные к объектам
     * @var
     */
    public $type;
}