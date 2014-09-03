<?php
/**
 * Your comment
 *
 * @author staygreengored <sggr90@gmail.com>
 * @since 1.0
 */

interface IMethod {

    /**
     * Получение имени метода для запроса к API
     * @return mixed
     */
    public function getMethodName();

    /**
     * Код метода
     * @return mixed
     */
    public function run();

} 