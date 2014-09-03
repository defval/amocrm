<?php
/**
 * Your comment
 *
 * @author staygreengored <sggr90@gmail.com>
 * @since 1.0
 */

class AmoLeadsList extends AmoGetMethod implements IMethod {

    public function getMethodName() {
        return '/private/api/v2/json/leads/list';
    }

    public function run() {
        //print_r($this->url);
        $data = $this->get();
        return $data['leads'];
    }

    /**
     * Кол-во выбираемых строк (системное ограничение 500)
     * @var
     */
    public $limit_rows;

    /**
     * Оффсет выборки (с какой строки выбирать) (Работает, только при условии, что limit_rows тоже указан)
     * @var
     */
    public $limit_offset;

    /**
     * Выбрать элемент с заданным ID (Если указан этот параметр, все остальные игнорируются)
     * (Можно передавать в виде массива состоящий из нескольких ID)
     * @var
     */
    public $id;

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
     * Фильтр по ID статуса сделки (Как узнать список доступных ID см. здесь)
     * @var
     */
    public $status;
} 