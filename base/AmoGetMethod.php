<?php
/**
 * Your comment
 *
 * @author staygreengored <sggr90@gmail.com>
 * @since 1.0
 */

class AmoGetMethod extends AmoMethod {

    /**
     * @return mixed
     */
    public function get() {
        $curl = curl_init(); #Сохраняем дескриптор сеанса cURL

        #Устанавливаем необходимые опции для сеанса cURL

        curl_setopt($curl, CURLOPT_URL, $this->url);
        $this->curlOptions($curl);


        $out = curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE); #Получим HTTP-код ответа сервера
        curl_close($curl); #Заверашем сеанс cURL

        //Проверяем ответ CURL
        $this->CheckCurlResponse($code);

        /**
         * Данные получаем в формате JSON, поэтому, для получения читаемых данных,
         * нам придётся перевести ответ в формат, понятный PHP
         */
        $response = json_decode($out, true);

        return $response['response'];
    }

    /**
     *
     */
    public function setUrl() {
        $params = get_object_vars($this);
        $this->url = 'https://'.$this->domain.'.amocrm.ru'.$this->getMethodName();
        $this->url .= '?type='.$this->type;
        foreach($params as $key=>$value) {
            if($key !== 'domain' && $key !== 'type' && $key !== 'url' && isset($value))
                $this->url .= '?'.$key.'='.$value;
        }
    }
}