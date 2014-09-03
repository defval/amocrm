<?php

/**
 * Your comment
 *
 * @author staygreengored <sggr90@gmail.com>
 * @since 1.0
 */
class AmoMethod
{

    /**
     * @var
     */
    protected $url;

    /**
     * @var
     */
    protected $domain;

    /**
     * @var string
     */
    protected $type = 'json';


    /**
     * @param $params
     * @throws CException
     * @throws Exception
     */
    public function __construct($params)
    {
        if (!is_array($params))
            throw new CException('$params must be array');
        ////print_r($params);
        $this->domain = $params['domain'];

        unset($params['domain']);
        $this->setParams($params);
        $this->setUrl();
    }


    /**
     * @param $params
     * @throws Exception
     */
    public function setParams($params)
    {
        $availableParams = get_object_vars($this);
        if (!empty($params)) {
            // 0 - first argument
            foreach ($params[0] as $key => $value) {
                if (array_key_exists($key, $availableParams))
                    $this->$key = $value;
                else
                    throw new Exception('param ' . $key . ' don not set in class ' . get_class($this));
            }
        }
    }

    /**
     * @param $code
     * @throws Exception
     */
    public function CheckCurlResponse($code)
    {
        $code = (int)$code;
        $errors = array(
            301 => 'Moved permanently',
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not found',
            500 => 'Internal server error',
            502 => 'Bad gateway',
            503 => 'Service unavailable'
        );

        #Если код ответа не равен 200 или 204 - возвращаем сообщение об ошибке
        if ($code != 200 && $code != 204)
            throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error', $code);
    }

    /**
     * @param $curl
     */
    public function curlOptions(&$curl)
    {
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    }
} 